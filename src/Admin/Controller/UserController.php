<?php

namespace Admin\Controller;

use Admin\Command\DeleteUserCommand;
use Admin\Command\UpdateUserCommand;
use Admin\Form\UserType;
use Crud\Domain\Exception\InvalidUserException;
use Crud\Domain\Model\User;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Crud\Infrastructure\Repository\Doctrine\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="admin_user_list")
     */
    public function userListAction(Request $request, UserRepository $userRepository, PaginatorInterface $paginator)
    {
        // set sort params
        $orderBy = array(
            'field' => $request->query->get('sort', 'created'),
            'asc' => $request->query->get('direction', 'desc')
        );

        // get users
        $users = $userRepository->getUsers(array(), $orderBy);
        // configure paginator
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            UserRepository::NUMBER_OF_RESULTS_PER_PAGE
        );

        // render template
        return $this->render(
            'Admin/user/user_list.html.twig',
            array(
                'users' => $pagination
            )
        );
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param TranslatorInterface $translator
     * @param CommandBus $commandBus
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Route("/user/add", name="admin_user_add")
     * @Route("/user/{userId}/update", name="admin_user_update")
     */
    public function updateAction(
        Request $request,
        UserRepository $userRepository,
        TranslatorInterface $translator,
        CommandBus $commandBus
    )
    {
        $updateUserCommand = new UpdateUserCommand();
        $userId = $request->get('userId');

        // set command parameters to those from database
        if ($userId) {
            /** @var User $user */
            $user = $userRepository->getById(Uuid::fromString($userId));

            if ($user instanceof User) {
                try {
                    $updateUserCommand->readFromActualParams($user);
                } catch (\Exception $e) {
                    $this->addFlash('error', $e->getMessage());

                    return $this->redirectToRoute('admin_user_list');
                }
            } else {
                throw InvalidUserException::forId(Uuid::fromString($userId));
//                $this->addFlash('error', $translator->trans('user_not_exists_error'));

                return $this->redirectToRoute('admin_user_list');
            }
        }

        // create form
        $form = $this->createForm(UserType::class, $updateUserCommand);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                try {
                    // update bundle data
                    $commandBus->handle($updateUserCommand);

                    // check if we have user create or update
                    $this->addFlash('notice', $translator->trans('user_update_success'));
                } catch (\Exception $e) {
                    $this->addFlash('error', $translator->trans('user_update_error').' '.$e->getMessage());
                }

                return $this->redirectToRoute('admin_user_list');
            }
        }

        return $this->render(
            'admin/user/user_update.html.twig',
            [
                'form' => $form->createView(),
                'userId' => $userId
            ]
        );
    }

    /**
     * @Route("/user/{userId}/delete", name="admin_user_delete")
     */
    public function deleteAction(
        Request $request,
        UserRepository $userRepository,
        TranslatorInterface $translator,
        CommandBus $commandBus
    )
    {
        $userId = $request->get('userId');
        if (!$userId) {
            $this->addFlash('error', $translator->trans('user_not_exists_error'));
        }

        /** @var User $user */
        $user = $userRepository->getById(Uuid::fromString($userId));

        if (!($user instanceof User)) {
            throw InvalidUserException::forId($userId);
        }

        try {
            $deleteUserCommand = new DeleteUserCommand($user);
            $commandBus->handle($deleteUserCommand);
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToRoute('admin_user_list');
        }

        $this->addFlash('success', $translator->trans('user_delete_success'));

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * @Route("/user/{userId}/view", name="admin_user_view")
     */
    public function viewAction(
        Request $request,
        UserRepository $userRepository,
        TranslatorInterface $translator
    )
    {
        $userId = $request->get('userId');
        if (!$userId) {
            $this->addFlash('error', $translator->trans('user_not_exists_error'));
        }

        /** @var User $user */
        $user = $userRepository->getById(Uuid::fromString($userId));

        if (!($user instanceof User)) {
            throw InvalidUserException::forId($userId);
        }

        return $this->render(
            'admin/user/user_view.html.twig',
            [
                'user' => $user
            ]
        );
    }
}

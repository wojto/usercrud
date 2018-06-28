<?php

namespace Admin\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Crud\Infrastructure\Repository\Doctrine\RoleRepository;
use Knp\Component\Pager\PaginatorInterface;

class RoleController extends AbstractController
{
    /**
     * @Route("/roles", name="admin_role_list")
     */
    public function roleListAction(Request $request, RoleRepository $roleRepository, PaginatorInterface $paginator)
    {
        // set sort params
        $orderBy = array(
            'field' => $request->query->get('sort', 'created'),
            'asc' => $request->query->get('direction', 'desc')
        );

        // get roles
        $roles = $roleRepository->getRoles(array(), $orderBy);
        // configure paginator
        $pagination = $paginator->paginate(
            $roles,
            $request->query->getInt('page', 1),
            RoleRepository::NUMBER_OF_RESULTS_PER_PAGE
        );

        // render template
        return $this->render(
            'admin/role/role_list.html.twig',
            array(
                'roles' => $pagination
            )
        );
    }
}

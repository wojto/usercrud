<?php

namespace Admin\Handler;

use Admin\Command\UpdateUserCommand;
use Crud\Domain\Model\User;
use Crud\Domain\Model\ValueObject\Email;
use Crud\Domain\Repository\RoleRepositoryInterface;
use Crud\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UpdateUserHandler
 * @package Admin\Handler
 */
class UpdateUserHandler
{
    /** @var UserRepositoryInterface */
    private $userRespository;

    /** @var RoleRepositoryInterface */
    private $roleRespository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UpdateUserHandler constructor.
     * @param UserRepositoryInterface $userRespository
     * @param RoleRepositoryInterface $roleRespository
     */
    public function __construct(
        UserRepositoryInterface $userRespository,
        RoleRepositoryInterface $roleRespository,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->userRespository = $userRespository;
        $this->roleRespository = $roleRespository;
        $this->encoder = $encoder;
    }

    /**
     * @param UpdateUserCommand $command
     * @return boolean
     */
    public function handle(UpdateUserCommand $command)
    {
        $user = null;
        if ($command->id) {
            /** @var User $user */
            $user = $this->userRespository->getById(
                Uuid::fromString($command->id)
            );
        }

        $role = $this->roleRespository->getById($command->roleId);

        if (!($user instanceof User)) {
            // create new user
            $user = new User(
                $role,
                $command->name,
                new Email($command->email),
                $command->twitterHandle
            );
            $user->setPassword(
                $this->encoder->encodePassword($user, $command->password)
            );
        } else {
            // update existing user
            $user
                ->setName($command->name)
                ->setRole($role)
                ->setEmail(new Email($command->email))
                ->setTwitterHandle($command->twitterHandle)
                ->setModified(new \DateTime());

            if (!empty($command->password)) {
                $user->setPassword($this->encoder->encodePassword($user, $command->password));
            }
        }

        // save object to database
        $this->userRespository->save($user);

        return true;
    }
}

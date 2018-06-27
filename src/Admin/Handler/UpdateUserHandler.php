<?php

namespace Admin\Handler;

use Admin\Command\UpdateUserCommand;
use Crud\Domain\Model\User;
use Crud\Domain\Model\ValueObject\Email;
use Crud\Domain\Repository\RoleRepositoryInterface;
use Crud\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;

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
     * UpdateUserHandler constructor.
     * @param UserRepositoryInterface $userRespository
     * @param RoleRepositoryInterface $roleRespository
     */
    public function __construct(
        UserRepositoryInterface $userRespository,
        RoleRepositoryInterface $roleRespository
    )
    {
        $this->userRespository = $userRespository;
        $this->roleRespository = $roleRespository;
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
                $command->twitterHandle,
                $command->password
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
                $user->setPassword($command->password);
            }
        }

        // save object to database
        $this->userRespository->save($user);

        return true;
    }
}

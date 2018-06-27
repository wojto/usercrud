<?php

namespace Admin\Handler;

use Admin\Command\DeleteUserCommand;
use Admin\Command\UpdateUserCommand;
use Crud\Domain\Model\User;
use Crud\Domain\Model\ValueObject\Email;
use Crud\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class DeleteUserHandler
 * @package Admin\Handler
 */
class DeleteUserHandler
{
    /** @var UserRepositoryInterface */
    private $userRespository;

    /**
     * DeleteUserHandler constructor.
     * @param UserRepositoryInterface $userRespository
     */
    public function __construct(
        UserRepositoryInterface $userRespository
    )
    {
        $this->userRespository = $userRespository;
    }

    /**
     * @param DeleteUserCommand $command
     * @return boolean
     */
    public function handle(DeleteUserCommand $command)
    {
        // delete object from database
        $this->userRespository->remove($command->user);

        return true;
    }
}

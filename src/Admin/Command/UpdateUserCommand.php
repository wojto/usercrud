<?php

namespace Admin\Command;

use Crud\Domain\Model\User;
use Ramsey\Uuid\UuidInterface;

/**
 * Class UpdateUserCommand
 * @package Admin\Command
 */
class UpdateUserCommand
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var UuidInterface
     */
    public $roleId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $twitterHandle;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeatedPassword;

    /**
     * @param User $user
     */
    public function readFromActualParams(User $user)
    {
        $this->id = $user->getId();
        // save user role object
        $this->roleId = $user->getRole()->getId();
        $this->name = $user->getName();
        $this->email = $user->getEmail();
        $this->twitterHandle = $user->getTwitterHandle();
    }
}

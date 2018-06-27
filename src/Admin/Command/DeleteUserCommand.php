<?php

namespace Admin\Command;

use Crud\Domain\Model\UserInterface;

/**
 * Class DeleteUserCommand
 * @package Admin\Command
 */
class DeleteUserCommand
{
    /**
     * @var UserInterface
     */
    public $user;

    /**
     * DeleteUserCommand constructor.
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }
}

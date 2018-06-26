<?php
declare(strict_types=1);

namespace Crud\Domain\Repository;

use Crud\Domain\Model\UserInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @package Shop\Domain\Repository
 */
interface UserRepositoryInterface
{
    /**
     * Return single user
     *
     * @param  UuidInterface $id
     * @return mixed
     */
    public function getById(UuidInterface $id);

    /**
     * Save user
     *
     * @param  UserInterface $user
     * @return mixed
     */
    public function save(UserInterface $user);

    /**
     * Return list of users
     *
     * @return mixed
     */
    public function getUsers();
}

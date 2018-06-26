<?php
declare(strict_types=1);

namespace Crud\Domain\Repository;

use Crud\Domain\Model\RoleInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface RoleRepositoryInterface
 *
 * @package Crud\Domain\Repository
 */
interface RoleRepositoryInterface
{
    /**
     * Return single role
     *
     * @param  UuidInterface $id
     * @return mixed
     */
    public function getById(UuidInterface $id);

    /**
     * Save role
     *
     * @param  RoleInterface $role
     * @return mixed
     */
    public function save(RoleInterface $role);

    /**
     * Return list of roles
     *
     * @return mixed
     */
    public function getRoles();
}

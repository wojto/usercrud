<?php

namespace Crud\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Crud\Domain\Model\RoleInterface;
use Crud\Domain\Repository\RoleRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Doctrine implementation of role repository
 *
 * @package Crud\Infrastructure\Repository\Doctrine
 */
class RoleRepository extends EntityRepository implements RoleRepositoryInterface
{
    /**
     * Return role from database
     *
     * @param  UuidInterface $id
     * @return null|object
     */
    public function getById(UuidInterface $id)
    {
        return $this->find($id);
    }

    /**
     * Save role in database
     *
     * @param RoleInterface $role
     */
    public function save(RoleInterface $role)
    {
        $this->_em->persist($role);
        $this->_em->flush($role);
    }

    /**
     * Search by criteria
     *
     * @param  $params array Search params
     * @param  $orderBy array Sort params
     * @return \Doctrine\ORM\Query
     */
    public function getRoles($params = [], $orderBy = [])
    {
        // prepare sort params
        if (empty($orderBy)) {
            $orderBy = [
                'field' => 'id',
                'asc' => 'asc'
            ];
        }
        switch ($orderBy['field']) {
            case 'created':
                $orderByField = 'u.created';
                break;
            case 'id':
            default:
                $orderByField = 'u.id';
                break;
        }
        $query = $this->createQueryBuilder('u')
            ->orderBy($orderByField, $orderBy['asc']);

        return $query
            ->getQuery();
    }
}

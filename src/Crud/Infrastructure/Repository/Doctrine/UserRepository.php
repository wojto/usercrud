<?php

namespace Crud\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Crud\Domain\Model\UserInterface;
use Crud\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Doctrine implementation of user repository
 *
 * @package Shop\Infrastructure\Repository\Doctrine
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * Return user from database
     *
     * @param  UuidInterface $id
     * @return null|object
     */
    public function getById(UuidInterface $id)
    {
        return $this->find($id);
    }

    /**
     * Save user in database
     *
     * @param UserInterface $user
     */
    public function save(UserInterface $user)
    {
        $this->_em->persist($user);
        $this->_em->flush($user);
    }

    /**
     * Search by criteria
     *
     * @param  $params array Search params
     * @param  $orderBy array Sort params
     * @return \Doctrine\ORM\Query
     */
    public function getUsers($params = [], $orderBy = [])
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

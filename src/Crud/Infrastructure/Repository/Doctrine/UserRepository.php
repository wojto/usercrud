<?php

namespace Crud\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use Crud\Domain\Model\UserInterface;
use Crud\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Doctrine implementation of user repository
 *
 * @package Crud\Infrastructure\Repository\Doctrine
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * Number of results on listing page
     */
    // @TODO temporary only for showing paginator
    const NUMBER_OF_RESULTS_PER_PAGE = 2;

    /**
     * @param UuidInterface $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getById(UuidInterface $id)
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.role', 'r')
            ->addSelect('r')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
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

    /**
     * @param UserInterface $user
     */
    public function remove(UserInterface $user)
    {
        $this->_em->remove($user);
        $this->_em->flush($user);
    }
}

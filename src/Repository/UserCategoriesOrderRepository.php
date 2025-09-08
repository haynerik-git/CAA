<?php

namespace App\Repository;

use App\Entity\UserCategoriesOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCategoriesOrder>
 *
 * @method UserCategoriesOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCategoriesOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCategoriesOrder[]    findAll()
 * @method UserCategoriesOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCategoriesOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCategoriesOrder::class);
    }

    //    /**
    //     * @return UserCategoriesOrder[] Returns an array of UserCategoriesOrder objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserCategoriesOrder
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

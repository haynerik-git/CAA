<?php

namespace App\Repository;

use App\Entity\UserCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCategories>
 *
 * @method UserCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCategories[]    findAll()
 * @method UserCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCategories::class);
    }

    //    /**
    //     * @return UserCategories[] Returns an array of UserCategories objects
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

    //    public function findOneBySomeField($value): ?UserCategories
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

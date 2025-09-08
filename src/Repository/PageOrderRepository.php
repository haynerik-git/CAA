<?php

namespace App\Repository;

use App\Entity\PageOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageOrder>
 *
 * @method PageOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageOrder[]    findAll()
 * @method PageOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageOrder::class);
    }

    //    /**
    //     * @return PageOrder[] Returns an array of PageOrder objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PageOrder
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

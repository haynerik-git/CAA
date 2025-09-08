<?php

namespace App\Repository;

use App\Entity\SentencesCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SentencesCategories>
 *
 * @method SentencesCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method SentencesCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method SentencesCategories[]    findAll()
 * @method SentencesCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentencesCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SentencesCategories::class);
    }

//    /**
//     * @return SentencesCategories[] Returns an array of SentencesCategories objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SentencesCategories
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

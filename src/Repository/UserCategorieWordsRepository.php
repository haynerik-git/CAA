<?php

namespace App\Repository;

use App\Entity\UserCategorieWords;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCategorieWords>
 *
 * @method UserCategorieWords|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCategorieWords|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCategorieWords[]    findAll()
 * @method UserCategorieWords[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCategorieWordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCategorieWords::class);
    }

    //    /**
    //     * @return UserCategorieWords[] Returns an array of UserCategorieWords objects
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

    //    public function findOneBySomeField($value): ?UserCategorieWords
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\SentencesTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SentencesTranslation>
 *
 * @method SentencesTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SentencesTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SentencesTranslation[]    findAll()
 * @method SentencesTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentencesTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SentencesTranslation::class);
    }

    //    /**
    //     * @return SentencesTranslation[] Returns an array of SentencesTranslation objects
    //     */
        public function findBySentenceId($value): array
        {
            return $this->createQueryBuilder('s')
                ->select('COALESCE(s.sentence, sentence.name) as res')
                ->leftJoin('s.sentenceTranslation', 'sentence')
                ->andWhere('sentence.id = :val')
                ->setParameter('val', $value['id'])
//                ->andWhere('s.lang = :val2')
//                ->setParameter('val2', $value['lang'])
                ->setMaxResults(1)
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?SentencesTranslation
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

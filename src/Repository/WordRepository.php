<?php

namespace App\Repository;

use App\Entity\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
/**
 * @extends ServiceEntityRepository<Word>
 *
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }

        public function findByWordsId($value): array
        {

           return $this->createQueryBuilder('w')
                ->andWhere('w.id IN ( :val )')
                ->setParameter('val',  $value)
                ->orderBy("field(w.id, ". implode(',', $value)." )")
//                ->orderBy("field(w.id, ". implode(',', $value)." )")
            ->getQuery()
                ->getResult()
            ;
        }

    public function search($value, $userId,  $langId = 1): array
    {

//        $entityManager = $this->getEntityManager();
//
//        $query = $entityManager->createQuery(
//            'SELECT w
//            FROM App\Entity\Word w
//            LEFT JOIN App\Entity\PageTranslation ON App\Entity\Word.id = App\Entity\PageTranslation.pageId
//            WHERE ( w.name LIKE :value and w.user = :userId )
//            or ( w.name LIKE :value and w.user is null )
//            ORDER BY w.name ASC'
//
//
//        )->setParameters(['value' => "%$value%", 'userId' => $userId ]);
//
//        // returns an array of Product objects
//        return $query->getResult();
//
//
//        $conn = $this->getEntityManager()->getConnection();
//
//        $sql = '
//            SELECT * FROM word w
//            WHERE w.name LIKE :value
//            ORDER BY w.name ASC
//            ';
//
//        $resultSet = $conn->executeQuery($sql, ['value' => "%$value%"]);
////
//        // returns an array of arrays (i.e. a raw data set)
//        return $resultSet->fetchAll();
        $queryBuilder = $this->createQueryBuilder('w');
//            ->Join('w.user', 'user', '', 'w.user = '.$userId )
        return $queryBuilder->leftJoin('w.wordTranslations', 'translation' ,'WITH', 'translation.lang = '.$langId )
//            ->where('translation.name like  :searchterm')

            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('w.user', $userId),
                    $queryBuilder->expr()->like('w.name', ':searchterm')
                )
            )

            ->orWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->isNull('w.user'),
                    $queryBuilder->expr()->like('w.name', ':searchterm')
                )
            )


            ->orWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->isNull('w.user'),
                    $queryBuilder->expr()->like('translation.name', ':searchterm'),
                )
            )

            ->orWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('w.user', $userId),
                    $queryBuilder->expr()->like('translation.name', ':searchterm')
                )
            )
//            ->where('w.name = :searchterm')
            ->setParameter('searchterm', '%'.$value.'%')

            ->orderBy("translation.name", 'asc')
//            ->orderBy("wl.name")
            ->getQuery()
            ->getResult()
            ;
    }

    //    /**
    //     * @return Word[] Returns an array of Word objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Word
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

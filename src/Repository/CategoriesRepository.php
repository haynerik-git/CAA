<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categories>
 *
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }


    //    /**
    //     * @return Categories[] Returns an array of Categories objects
    //     */
    public function findByWord($value): array
    {
        $qb = $this->createQueryBuilder('s');
        return $qb->select('s')
//            ->select('COALESCE(sentence.sentence,s.name) as res')
//            ->setParameter('val2', $value['lang'])
//            ->leftJoin('s.sentencesTranslations', 'sentence' ,'WITH', 'sentence.lang = :val2' )
            ->setParameter('val2', $value["lastWord"])
            ->innerJoin('s.afterWords', 'afterWords' ,'WITH', 'afterWords.id = :val2' )
         //   ->orderBy('afterWords.display_order')
            ->getQuery()
            ->getResult()
            ;
    }

    //    /**
    //     * @return Categories[] Returns an array of Categories objects
    //     */
    public function findByCategories($value): array
    {
        $qb = $this->createQueryBuilder('s');
        
        return $qb->select('s')
                ->setParameter('catId', $value)
                ->innerJoin('s.categoriesParent', 'categoriesParent' ,'WITH', 'categoriesParent.id = :catId' )
            //->groupBy('s.display_order')
            ->orderBy('s.display_order')
            ->getQuery()
            ->getResult()
            ;
    }
    //    /**
    //     * @return Categories[] Returns an array of Categories objects
    //     */
        public function findByWordBAd($value): array
        {
            $qb = $this->createQueryBuilder('s');
            $qb
//            ->select('s.id')
//            ->from(SentencesTranslation::class, 'se')
//            ->from(Sentences::class, 's')
                ->select('s')
//            ->from('Categorie', 's')
//            ->from('SentencesTranslation', 'sentence')
//                ->andWhere('s.id = :val')
//                ->setParameter('val', $value['id'])
//                ->andWhere('se.lang = :val2')
                ->setParameter('val2', $value["lastWord"])
                ->innerJoin('s.afterWords', 'afterWords' ,'WITH', 'afterWords.id = :val2' )
           //     ->orderBy('afterWords.display_order')
//                ->setParameter('catId', $value["lastCategorie"])
//                ->innerJoin('s.categoriesParent', 'categoriesParent' ,'WITH', 'categoriesParent.id = :catId' )
                    ;
           return $qb
//               ->having($qb->expr()->gt($qb->expr()->count('s.categoriesParent'), 0))
//                ->orderBy('s.display_order')
//                ->setMaxResults(2)
//                ->having($qb->expr()->gt($qb->expr()->count('s.categoriesParent'), 0))
                ->getQuery()
                ->getResult()
                ;
            return $this->createQueryBuilder('c')
//                ->leftJoin('c.categoriesWord', 'n')
//                ->where('n.id = :val')
//                ->setParameter('val', $value)
                ->orderBy('c.id', 'ASC')
//                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findOneBySomeField($value): ?array
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.id = :val')
                ->setParameter('val', $value)
                ->orderBy('c.display_order', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

    public function findAllOrdered(): ?array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.display_order', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}

<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findPageByOrder(): ?array
    {
        return $this->createQueryBuilder('p')
            ->where('p.visible = 1')
//            ->setParameter('val', $value)
            ->orderBy('p.displayOrder', 'ASC')
            ->getQuery()
            ->enableResultCache(3600, 'HOME')
            ->useQueryCache(true)
            ->getResult()
            ;
    }

        public function findNextByOrder($value): ?Page
        {
            return $this->createQueryBuilder('p')
                ->where('p.displayOrder > :val')
                ->andWhere('p.visible = 1')
                ->setParameter('val', $value)
                ->orderBy('p.displayOrder', 'ASC')
//                ->limit(1)
                ->setMaxResults(1)
                ->getQuery()
                ->useQueryCache(true)
                ->enableResultCache()
                ->getOneOrNullResult()
            ;
        }

    public function findPrevByOrder($value): ?Page
    {
        return $this->createQueryBuilder('p')
            ->where('p.displayOrder < :val')
            ->andWhere('p.visible = 1')
            ->setParameter('val', $value)
            ->orderBy('p.displayOrder', 'DESC')
//                ->limit(1)
            ->setMaxResults(1)
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache()
            ->getOneOrNullResult()
            ;
    }

    public function search($value, $langId = 1): array
    {

        return $this->createQueryBuilder('p')
            ->leftJoin('p.pageTranslations', 'translation' ,'WITH', 'translation.lang = '.$langId )
            ->where('translation.name like  :searchterm')
            ->orWhere('p.title like  :searchterm')
//            ->where('w.name = :searchterm')
            ->setParameter('searchterm', '%'.$value.'%')

            ->orderBy("translation.name")
//            ->orderBy("wl.name")
            ->getQuery()
            ->getResult()
            ;
    }

    //    /**
    //     * @return Page[] Returns an array of Page objects
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

    //    public function findOneBySomeField($value): ?Page
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

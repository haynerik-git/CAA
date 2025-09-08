<?php

namespace App\Repository;

use App\Entity\Sentences;
use App\Entity\SentencesTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sentences>
 *
 * @method Sentences|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sentences|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sentences[]    findAll()
 * @method Sentences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sentences::class);
    }

    //    /**
    //     * @return Sentences[] Returns an array of Sentences objects
    //     */
    public function findBySentenceId($value): array
    {
        return $this->createQueryBuilder('s')
//            ->select('s.id')
//            ->from(SentencesTranslation::class, 'se')
//            ->from(Sentences::class, 's')
            ->select('COALESCE(sentence.sentence,s.name) as res')
//            ->from('Sentences', 's')
//            ->from('SentencesTranslation', 'sentence')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value['id'])
//                ->andWhere('se.lang = :val2')
                ->setParameter('val2', $value['lang'])
            ->leftJoin('s.sentencesTranslations', 'sentence' ,'WITH', 'sentence.lang = :val2' )
            ->orderBy('s.display_order')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByCat($value): array
    {
        $qb = $this->createQueryBuilder('s');
        return $qb->select('s')
//            ->select('COALESCE(sentence.sentence,s.name) as res')
//            ->setParameter('val2', $value['lang'])
//            ->leftJoin('s.sentencesTranslations', 'sentence' ,'WITH', 'sentence.lang = :val2' )
            ->setParameter('val2', $value)
            ->innerJoin('s.sentences', 'sentences' ,'WITH', 'sentences.id = :val2' )
            //   ->orderBy('afterWords.display_order')
            ->getQuery()
            ->getResult()
            ;
    }

}

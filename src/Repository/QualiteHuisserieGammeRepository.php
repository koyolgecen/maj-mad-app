<?php

namespace App\Repository;

use App\Entity\QualiteHuisserieGamme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QualiteHuisserieGamme|null find($id, $lockMode = null, $lockVersion = null)
 * @method QualiteHuisserieGamme|null findOneBy(array $criteria, array $orderBy = null)
 * @method QualiteHuisserieGamme[]    findAll()
 * @method QualiteHuisserieGamme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualiteHuisserieGammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QualiteHuisserieGamme::class);
    }

    // /**
    //  * @return QualiteHuisserieGamme[] Returns an array of QualiteHuisserieGamme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QualiteHuisserieGamme
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

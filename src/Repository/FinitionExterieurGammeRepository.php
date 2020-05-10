<?php

namespace App\Repository;

use App\Entity\FinitionExterieurGamme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FinitionExterieurGamme|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinitionExterieurGamme|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinitionExterieurGamme[]    findAll()
 * @method FinitionExterieurGamme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinitionExterieurGammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinitionExterieurGamme::class);
    }

    // /**
    //  * @return FinitionExterieurGamme[] Returns an array of FinitionExterieurGamme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinitionExterieurGamme
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

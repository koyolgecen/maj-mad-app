<?php

namespace App\Repository;

use App\Entity\CouvertureGamme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CouvertureGamme|null find($id, $lockMode = null, $lockVersion = null)
 * @method CouvertureGamme|null findOneBy(array $criteria, array $orderBy = null)
 * @method CouvertureGamme[]    findAll()
 * @method CouvertureGamme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouvertureGammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CouvertureGamme::class);
    }

    // /**
    //  * @return CouvertureGamme[] Returns an array of CouvertureGamme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CouvertureGamme
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

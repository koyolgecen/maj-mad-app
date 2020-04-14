<?php

namespace App\Repository;

use App\Entity\Marge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Marge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marge[]    findAll()
 * @method Marge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marge::class);
    }

    // /**
    //  * @return Marge[] Returns an array of Marge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marge
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

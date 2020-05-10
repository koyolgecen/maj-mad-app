<?php

namespace App\Repository;

use App\Entity\RegleCalcul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RegleCalcul|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegleCalcul|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegleCalcul[]    findAll()
 * @method RegleCalcul[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegleCalculRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegleCalcul::class);
    }

    // /**
    //  * @return RegleCalcul[] Returns an array of RegleCalcul objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegleCalcul
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

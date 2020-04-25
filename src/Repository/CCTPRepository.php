<?php

namespace App\Repository;

use App\Entity\CCTP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CCTP|null find($id, $lockMode = null, $lockVersion = null)
 * @method CCTP|null findOneBy(array $criteria, array $orderBy = null)
 * @method CCTP[]    findAll()
 * @method CCTP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CCTPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CCTP::class);
    }

    // /**
    //  * @return CCTP[] Returns an array of CCTP objects
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
    public function findOneBySomeField($value): ?CCTP
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

<?php

namespace App\Repository;

use App\Entity\CoupeDePrincipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CoupeDePrincipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoupeDePrincipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoupeDePrincipe[]    findAll()
 * @method CoupeDePrincipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoupeDePrincipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoupeDePrincipe::class);
    }

    // /**
    //  * @return CoupeDePrincipe[] Returns an array of CoupeDePrincipe objects
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
    public function findOneBySomeField($value): ?CoupeDePrincipe
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

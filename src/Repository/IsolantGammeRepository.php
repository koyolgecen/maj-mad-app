<?php

namespace App\Repository;

use App\Entity\IsolantGamme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IsolantGamme|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsolantGamme|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsolantGamme[]    findAll()
 * @method IsolantGamme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsolantGammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IsolantGamme::class);
    }

    // /**
    //  * @return IsolantGamme[] Returns an array of IsolantGamme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IsolantGamme
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

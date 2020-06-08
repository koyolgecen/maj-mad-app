<?php

namespace App\Repository;

use App\Entity\PaiementEchelonne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PaiementEchelonne|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaiementEchelonne|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaiementEchelonne[]    findAll()
 * @method PaiementEchelonne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaiementEchelonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaiementEchelonne::class);
    }

    // /**
    //  * @return PaiementEchelonne[] Returns an array of PaiementEchelonne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PaiementEchelonne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

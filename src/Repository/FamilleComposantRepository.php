<?php

namespace App\Repository;

use App\Entity\FamilleComposant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FamilleComposant|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleComposant|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleComposant[]    findAll()
 * @method FamilleComposant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleComposantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilleComposant::class);
    }

    // /**
    //  * @return FamilleComposant[] Returns an array of FamilleComposant objects
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
    public function findOneBySomeField($value): ?FamilleComposant
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

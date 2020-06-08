<?php

namespace App\Repository;

use App\Entity\EtatDevis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EtatDevis|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatDevis|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatDevis[]    findAll()
 * @method EtatDevis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatDevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatDevis::class);
    }

    // /**
    //  * @return EtatDevis[] Returns an array of EtatDevis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatDevis
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

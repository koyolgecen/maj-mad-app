<?php

namespace App\Repository;

use App\Entity\CaracteristiqueNature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CaracteristiqueNature|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracteristiqueNature|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracteristiqueNature[]    findAll()
 * @method CaracteristiqueNature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracteristiqueNatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaracteristiqueNature::class);
    }

    // /**
    //  * @return CaracteristiqueNature[] Returns an array of CaracteristiqueNature objects
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
    public function findOneBySomeField($value): ?CaracteristiqueNature
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

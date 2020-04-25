<?php

namespace App\Repository;

use App\Entity\UniteNature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UniteNature|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniteNature|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniteNature[]    findAll()
 * @method UniteNature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniteNatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UniteNature::class);
    }

    // /**
    //  * @return UniteNature[] Returns an array of UniteNature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UniteNature
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

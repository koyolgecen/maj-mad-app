<?php

namespace App\Repository;

use App\Entity\ModeleARealiser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ModeleARealiser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeleARealiser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeleARealiser[]    findAll()
 * @method ModeleARealiser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeleARealiserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeleARealiser::class);
    }

    // /**
    //  * @return ModeleARealiser[] Returns an array of ModeleARealiser objects
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
    public function findOneBySomeField($value): ?ModeleARealiser
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

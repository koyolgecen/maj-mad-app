<?php

namespace App\Repository;

use App\Entity\ModuleARealiser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ModuleARealiser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleARealiser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleARealiser[]    findAll()
 * @method ModuleARealiser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleARealiserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleARealiser::class);
    }

    // /**
    //  * @return ModuleARealiser[] Returns an array of ModuleARealiser objects
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
    public function findOneBySomeField($value): ?ModuleARealiser
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

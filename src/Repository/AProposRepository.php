<?php

namespace App\Repository;

use App\Entity\APropos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method APropos|null find($id, $lockMode = null, $lockVersion = null)
 * @method APropos|null findOneBy(array $criteria, array $orderBy = null)
 * @method APropos[]    findAll()
 * @method APropos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AProposRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, APropos::class);
    }

    // /**
    //  * @return APropos[] Returns an array of APropos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?APropos
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

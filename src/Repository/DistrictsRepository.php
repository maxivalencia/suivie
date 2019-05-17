<?php

namespace App\Repository;

use App\Entity\Districts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Districts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Districts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Districts[]    findAll()
 * @method Districts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistrictsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Districts::class);
    }

    // /**
    //  * @return Districts[] Returns an array of Districts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Districts
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

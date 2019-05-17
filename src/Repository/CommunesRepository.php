<?php

namespace App\Repository;

use App\Entity\Communes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Communes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Communes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Communes[]    findAll()
 * @method Communes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Communes::class);
    }

    // /**
    //  * @return Communes[] Returns an array of Communes objects
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
    public function findOneBySomeField($value): ?Communes
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

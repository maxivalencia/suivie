<?php

namespace App\Repository;

use App\Entity\Traitements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Traitements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Traitements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Traitements[]    findAll()
 * @method Traitements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraitementsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Traitements::class);
    }

    // /**
    //  * @return Traitements[] Returns an array of Traitements objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Traitements
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

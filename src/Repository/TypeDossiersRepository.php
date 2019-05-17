<?php

namespace App\Repository;

use App\Entity\TypeDossiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeDossiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDossiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDossiers[]    findAll()
 * @method TypeDossiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDossiersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeDossiers::class);
    }

    // /**
    //  * @return TypeDossiers[] Returns an array of TypeDossiers objects
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
    public function findOneBySomeField($value): ?TypeDossiers
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

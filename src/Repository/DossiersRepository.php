<?php

namespace App\Repository;

use App\Entity\Dossiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Orx;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @method Dossiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dossiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dossiers[]    findAll()
 * @method Dossiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dossiers::class);
    }

    // /**
    //  * @return Dossiers[] Returns an array of Dossiers objects
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
    public function findOneBySomeField($value): ?Dossiers
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosFini($value1, $value2 = null)
    {
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            //->andWhere('d.unitedestinataire = :val2 or d.uniteorigine = :val3')
            ->andWhere('d.uniteorigine = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            //->setParameter('val3', $value2)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosFiniRechercher($value1, $value2 = null, $recherche = null)
    {
        $myDateTime = new DateTime($recherche);
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            //->andWhere('d.unitedestinataire = :val2 or d.uniteorigine = :val3')
            ->andWhere('d.uniteorigine = :val2')
            ->andWhere('d.objet LIKE :val4 OR d.daterecepeffectif BETWEEN  :val5 AND :val6')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            //->setParameter('val3', $value2)
            ->setParameter('val4', '%'.$recherche.'%')
            ->setParameter('val5', date_create($recherche.' 00:00:00'))
            ->setParameter('val6', date_create($recherche.' 23:59:59'))
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosAttente($value1, $value2 = null)
    {
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            ->andWhere('d.uniteorigine = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosAttenteRechercher($value1, $value2 = null, $recherche = null)
    {
        $myDateTime = new DateTime($recherche);
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            ->andWhere('d.uniteorigine = :val2')
            ->andWhere('d.objet LIKE :val3 OR d.daterecepeffectif BETWEEN  :val5 AND :val6')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', '%'.$recherche.'%')
            ->setParameter('val5', date_create($recherche.' 00:00:00'))
            ->setParameter('val6', date_create($recherche.' 23:59:59'))
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosNonRecue($value1, $value2 = null)
    {
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            ->andWhere('d.unitedestinataire = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            //->setParameter('val3', $value3)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosNonRecueRechercher($value1, $value2 = null, $value3 = null, $recherche = null)
    {
        $myDateTime = new DateTime($recherche);
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            ->andWhere('d.unitedestinataire = :val2')
            ->andWhere('d.objet LIKE :val4 OR d.daterecepeffectif BETWEEN  :val5 AND :val6')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            //->setParameter('val3', $value3)
            ->setParameter('val4', '%'.$recherche.'%')
            ->setParameter('val5', date_create($recherche.' 00:00:00'))
            ->setParameter('val6', date_create($recherche.' 23:59:59'))
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosEnCours($value1, $value2)
    {
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            ->andWhere('d.unitedestinataire = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }   

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */
    
    public function findByDosEnCoursRechercher($value1, $value2 = null, $recherche = null)
    {
        $myDateTime = new DateTime($recherche);
        return $this->createQueryBuilder('d')
            ->Where('d.traitement = :val1')
            ->andWhere('d.unitedestinataire = :val2')
            ->andWhere('d.objet LIKE :val3 OR d.daterecepeffectif BETWEEN  :val5 AND :val6')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', '%'.$recherche.'%')
            ->setParameter('val5', date_create($recherche.' 00:00:00'))
            ->setParameter('val6', date_create($recherche.' 23:59:59'))
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }     

    /**
     * @return Dossiers[] Returns an array of Dossiers objects
     */

     public function Trouver($recherche)
     {
        $myDateTime = new DateTime($recherche);
        return $this->createQueryBuilder('d')
            ->Where('d.objet LIKE :val OR d.daterecepeffectif BETWEEN  :val5 AND :val6')
            ->setParameter('val', '%'.$recherche.'%')
            ->setParameter('val5', date_create($recherche.' 00:00:00'))
            ->setParameter('val6', date_create($recherche.' 23:59:59'))
            ->orderBy('d.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
     }
}

<?php

namespace App\Repository;

use App\Entity\Outing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method Outing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Outing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Outing[]    findAll()
 * @method Outing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Outing::class);
    }

    public function findOutingOuJESuisLOrg($organisateur)
    {

       return $this->createQueryBuilder('o')
              ->innerJoin('o.organisateur','org')
              ->andWhere('org= :user')
              ->setParameter('user', $organisateur)
              ->getQuery()
              ->getResult();

    }

    public function findByFiltre($campusSelected ,$organisateur)
    {
        dump("hello");
        dump("campus",$campusSelected,"orga" ,$organisateur,"inscrit");
        //,$jeSuisInscrit,"nonInscrit",$nonInscrit,"oldsorties",$sortiesPassees
        $today = new date();

        $queryBuilder = $this->createQueryBuilder('o');
            $queryBuilder->select('o');


        if($campusSelected)
        {
            dump("campus {$campusSelected}");
            $queryBuilder = $queryBuilder
                ->andWhere('o.campus  = :campus')
                ->setParameter('campus', $campusSelected);

        }

        if($organisateur) {
            dump( "org {$organisateur}");
            $queryBuilder = $queryBuilder
                ->innerJoin('o.organisateur','org')
                ->andWhere('org= :user')
                ->setParameter('user', $organisateur);

        }
/*
        if($jeSuisInscrit)
       {
            $queryBuilder =$queryBuilder

                ->andWhere('o.users= :user')
                ->setParameter('user', $jeSuisInscrit);

        }

        if($nonInscrit)
        {
           $queryBuilder =$queryBuilder
                ->andWhere('o.users != :user')
                ->setParameter('user', $nonInscrit);

        }
*/
  /*      if($sortiesPassees)
        {

            $queryBuilder =$queryBuilder

                ->andWhere('o.dateHeureDebut < :date')
                ->setParameter('date', $today);

        }
*/

        return $queryBuilder->getQuery()->getResult();
    }



    // /**
    //  * @return Outing[] Returns an array of Outing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Outing
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

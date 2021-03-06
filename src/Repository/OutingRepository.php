<?php

namespace App\Repository;

use App\Entity\Outing;

use App\Form\OutingType;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;



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

    public function findByFiltre($campusSelected ,$organisateur,$jeSuisInscrit,$nonInscrit,$sortiesPassees,$rechercheSorties,$dateEntre,$etDate)
    {
        dump("hello");
        dump("campus :" . $campusSelected . "orga :" . $organisateur . " inscrit :" . $jeSuisInscrit . " nonInscrit :" . $nonInscrit . " oldsorties : " . $sortiesPassees . " recherche : ".$rechercheSorties);

        $today = new dateTime();

        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder->select('o');


        if ($campusSelected) {
            dump("campus {$campusSelected}");
            $queryBuilder = $queryBuilder
                ->andWhere('o.campus  = :campus')
                ->setParameter('campus', $campusSelected);
        }

        if ($organisateur) {
            dump("org {$organisateur}");
            $queryBuilder = $queryBuilder
                ->Join('o.organisateur', 'org')
                ->andWhere('org= :user')
                ->setParameter('user', $organisateur);
        }

        if (!empty($jeSuisInscrit) && !empty($nonInscrit)) {

            dump("voila voila !");

        } else
            {
                $queryBuilder
                    ->addSelect('u')
                    ->leftJoin('o.users', 'u');

                    if ($jeSuisInscrit) {
                        dump("inscrit {$jeSuisInscrit}");
                        $queryBuilder
                            ->andWhere('u= :user')
                            ->setParameter('user', $jeSuisInscrit);
                    }

                    if ($nonInscrit) {
                        dump(" nonInscrit {$nonInscrit}");
                        $queryBuilder
                            ->andWhere('u!= :user')
                            ->setParameter('user', $nonInscrit);
                    }
            }


      if($sortiesPassees)
              {
            dump(" sortiePassees  {$sortiesPassees}");
            $queryBuilder
                ->andWhere('o.dateHeureDebut < :date')
                ->setParameter('date', $today);
        }


        if(($dateEntre && $etDate)||($dateEntre || $etDate))
        {
            dump(" date entre  {$dateEntre}");
            dump(" et date  {$etDate}");

             if(($dateEntre && !$etDate)){
                 dump("date de debut");
                 $queryBuilder
                     ->andWhere('o.dateHeureDebut >= :dateEntre')
                     ->setParameter('dateEntre', $dateEntre);

             }

            if(($etDate && !$dateEntre)) {
                dump("date de fin");
                $queryBuilder
                    ->andWhere('o.dateHeureDebut <= :date')
                    ->setParameter('date', $etDate);

            }

            if(($dateEntre && $etDate)){
                dump("date de debut et de fin");
                $queryBuilder
                    ->andWhere('o.dateHeureDebut >= :dateEntre')
                    ->setParameter('dateEntre', $dateEntre)
                    ->andWhere('o.dateHeureDebut <= :datefin')
                    ->setParameter('datefin', $etDate);

            }

        }



        if(!empty($rechercheSorties)) {
            $queryBuilder
                ->andWhere('o.nom LIKE :r')
                ->setParameter('r', "%{$rechercheSorties}%");
            dump($rechercheSorties);
            dump("dans recherche");
        }

        $queryBuilder
            ->orderBy('o.dateHeureDebut','ASC');
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

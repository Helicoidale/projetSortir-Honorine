<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Outing;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutingController extends AbstractController
{
    /**
     * @Route("/outing", name="outing")
     */
    public function index(): Response
    {
        return $this->render('outing/index.html.twig', [
            'controller_name' => 'OutingController',
        ]);
    }

    /**
     * @Route ("/outing/listeSorties" , name="outing_listeSorties")
     */
    public function listeSorties(Request $request):Response
    {
        dump($request->query->all());

        $user=$this->getUser();

        // permet de recupere les campus pour le menu deroulant de la vue

        $campusRepo=$this->getDoctrine()->getRepository(Campus::class);
        $listeCampus=$campusRepo->findAll();

        //========= récupération de tous les champs =========

        $campusSelected=isset($_GET['campusSelected']) ? $_GET['campusSelected'] : NULL;
        $organisateur=isset($_GET['organisateur']) ? $_GET['organisateur'] : NULL;
        $jeSuisInscrit=isset($_GET['jeSuisInscrit']) ? $_GET['jeSuisInscrit'] : NULL;
        $nonInscrit=isset($_GET['nonInscrit']) ? $_GET['nonInscrit'] : NULL;
        $sortiesPassees=isset($_GET['sortiesPassees']) ? $_GET['sortiesPassees'] : NULL;

        dump($campusSelected);
        dump($organisateur);
        dump($jeSuisInscrit);
        dump($nonInscrit);
        dump($sortiesPassees);

        //========= passage des champs a la fonction findByFiltre =======

        if($campusSelected== null && $organisateur== null && $jeSuisInscrit== null && $nonInscrit== null && $sortiesPassees== null ){
            dump("je suis là fonction ou tout est null");
            $sortiesRepo = $this->getDoctrine()->getRepository(Outing::class);
            $listeSorties = $sortiesRepo->findAll();
        }
        else {
            dump("sinon je suis la foction avec filtre");
            $sortiesRepo = $this->getDoctrine()->getRepository(Outing::class);
            $listeSorties = $sortiesRepo->findByFiltre($campusSelected, $organisateur,$jeSuisInscrit,$nonInscrit,$sortiesPassees);

        }

        return $this->render('outing/listeSorties.html.twig',[
            'listeSorties'=>$listeSorties,
            'user'=>$user,
            'listeCampus'=>$listeCampus
        ]);

    }

    /**
     * @param $id
     * @return Response
     * @Route ("/outing/{id}",name="outing_detailSortie")
     */
    public function detailSortie($id):Response
    {
        dump($id);
        $sortieRepo=$this->getDoctrine()->getRepository(Outing::class);
        $detailSortie=$sortieRepo->find($id);
        dump($detailSortie);

        $idCampus = $detailSortie->getCampus()->getid();
        dump($idCampus);
        $campusRepo=$this->getDoctrine()->getRepository(Campus::class);
        $campus=$campusRepo->find($idCampus);

        //$idOrganisateur = $detailSortie->getOrganisateur()->getid();
       // dump($idOrganisateur);
       // $organisateurRepo=$this->getDoctrine()->getRepository(User::class);
       // $organisateur=$organisateurRepo->find($idOrganisateur);




        return $this->render('outing/detailsortie.html.twig',[
            'sortie'=>$detailSortie,
            'campus'=>$campus
        ]);
    }

}


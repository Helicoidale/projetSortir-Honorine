<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Outing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function listeSorties():Response
    {
        $sortiesRepo=$this->getDoctrine()->getRepository(Outing::class);
        $listeSorties=$sortiesRepo->findAll();

        return $this->render('outing/listeSorties.html.twig',[
            'listeSorties'=>$listeSorties,

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


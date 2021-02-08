<?php

namespace App\Controller;

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
        //findSortiesAvecToutesLesInfo();


        return $this->render('outing/listeSorties.html.twig',[
            'listeSorties'=>$listeSorties,

            ]);
    }
}

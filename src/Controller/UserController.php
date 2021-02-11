<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/monProfil", name="user_monProfil")
     */
    public function afficherProfil(): Response
    {

        $user = $this->getUser();
        dump($user);

        $campus = $this->getUser()->getCampus()->getnom();

        return $this->render('user/monProfil.html.twig', [
            'user' => $user,
            'campus' => $campus,
        ]);
    }

    /**
     * @Route ("/modifierProfil" , name="user_modifierProfil")
     * @param Request $request
     * @return Response
     */
    public function modifierProfil(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = $this->getUser();

        dump($user);
        dump($request);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $form->get('oldPassword')->getData();

            dump($oldPassword);
            //Si l'ancien mot de passe est bon

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {


               $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

                $user->setPassword($newEncodedPassword);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('user_monProfil');

            } else {

                return $this->render('user/modifierProfil.html.twig', [
                    'user' => $user,
                    'form' => $form->createView()
                ]);
            }


        }

            dump($user);

            return $this->render('user/modifierProfil.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);


    }

    /**
     * @Route("/unProfil", name="user_unProfil")
     */
    public function afficherUnProfil(Request $request): Response
    {
        dump($request);
        $autreUser= $request->query->get('id');
        dump($autreUser);
        $userRepo=$this->getDoctrine()->getRepository(User::class);
        $autreUser=$userRepo->find($autreUser);
        dump($autreUser);


        $campus = $this->getUser()->getCampus()->getnom();

        return $this->render('user/unProfil.html.twig', [
            'autreUser' => $autreUser,
            'campus' => $campus,
        ]);
    }

}





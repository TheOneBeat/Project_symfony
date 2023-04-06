<?php

namespace App\Controller\Vente;

use App\Entity\User;
use App\Form\UserType;
use App\Service\PasswordChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('form', name: 'form')]
class FormController extends AbstractController
{
    #[Route('/createUser', name: '_createUser')]
    public function createUser (EntityManagerInterface $em,Request $request,
                                UserPasswordHasherInterface $passwordHasher,PasswordChecker $ps): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $pass = "";
        if (!is_null($form->get('password')->getData()))
        {
            $pass = $form->get('password')->getData();
        }

        $checkpassword = $ps->isPasswordRobust($pass);


        if ($form->isSubmitted() && $form->isValid() && $checkpassword['isValid'])
        {
            $passwordUser1 = $passwordHasher->hashPassword($user,
                $form->get('password')->getData());

            $user->setPassword($passwordUser1);
            $user->setRoles(["ROLE_CLIENT"]);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "customer account created successfully !");

            return $this->redirectToRoute('accueil');
        }

        $this->addFlash('failure', $checkpassword["errorMessage"]);


        return $this->render('user/user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/createAdmin', name: '_createAdmin')]
    public function createAdmin (EntityManagerInterface $em,Request $request,
                                UserPasswordHasherInterface $passwordHasher,PasswordChecker $ps): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $pass = "";
        if (!is_null($form->get('password')->getData()))
        {
            $pass = $form->get('password')->getData();
        }

        $checkpassword = $ps->isPasswordRobust($pass);

        if ($form->isSubmitted() && $form->isValid() && $checkpassword['isValid'])
        {
            $passwordUser1 = $passwordHasher->hashPassword($user,
                $form->get('password')->getData());

            $user->setPassword($passwordUser1);
            $user->setRoles(["ROLE_ADMIN"]);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success',  "customer account created successfully !");

            return $this->redirectToRoute('accueil');
        }

        $this->addFlash('failure', $checkpassword["errorMessage"]);

        return $this->render('user/user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/editProfil', name: '_editProfil')]
    public function editProfil(EntityManagerInterface $em,Request $request,
                               UserPasswordHasherInterface $passwordHasher, PasswordChecker $ps): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $pass = "";
        if (!is_null($form->get('password')->getData()))
        {
            $pass = $form->get('password')->getData();
        }

        $checkpassword = $ps->isPasswordRobust($pass);

        if ($form->isSubmitted() && $form->isValid() && $checkpassword['isValid'])
        {

            $passwordUser = $passwordHasher->hashPassword($user,
                $form->get('password')->getData());

            $user->setPassword($passwordUser);
            $em->flush();


            $this->addFlash('success', "Profile updated successfully !");



            return $this->redirectToRoute('accueil');
        }

        $this->addFlash('failure', $checkpassword["errorMessage"]);

        return $this->render('user/user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

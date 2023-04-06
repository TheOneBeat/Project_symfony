<?php

namespace App\Controller\Vente;

use App\Entity\Produit;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/vente', name: 'vente')]
class SecurityTestController extends AbstractController
{
    #[Route('/addUsers', name: '_addUsers')]
    public function addUsers(EntityManagerInterface $em,
                             UserPasswordHasherInterface $passwordHasher):Response
    {
        //===================ROLE CLIENT SIMON =========================

        $user1 = new User();
        $user1
            ->setLogin('simon')
            ->setName("ingle")
            ->setRoles(['ROLE_CLIENT'])
            ->setFirstName("Arthur")
            ->setBirthday(new \DateTime("1980-02-23"));
        $passwordUser1 = $passwordHasher->hashPassword($user1,'nomis');
        $user1->setPassword($passwordUser1);
        $em->persist($user1);


        //===================ROLE CLIENT RITA =========================

        $user2 = new User();
        $user2
            ->setLogin('rita')
            ->setName("zouri")
            ->setRoles(['ROLE_CLIENT'])
            ->setFirstName("Rita")
            ->setBirthday(new \DateTime("1983-06-15"));
        $passwordUser2 = $passwordHasher->hashPassword($user2,'atir');
        $user2->setPassword($passwordUser2);
        $em->persist($user2);

        //===================ROLE ADMIN GILLES =========================

        $user3 = new User();
        $user3
            ->setLogin('gilles')
            ->setName("Subrenat")
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName("Gilou")
            ->setBirthday(new \DateTime("1983-06-15"));
        $passwordUser3 = $passwordHasher->hashPassword($user3,'sellig');
        $user3->setPassword($passwordUser3);
        $em->persist($user3);

        //===================ROLE SUPER_ADMIN  =========================

        $user4 = new User();
        $user4
            ->setLogin('sadmin')
            ->setName("super")
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setFirstName("franky")
            ->setBirthday(new \DateTime("1983-06-15"));
        $passwordUser4 = $passwordHasher->hashPassword($user4,'nimdas');
        $user4->setPassword($passwordUser4);
        $em->persist($user4);

        $user5 = new User();
        $user5
            ->setLogin('dark')
            ->setName("luke")
            ->setRoles(['ROLE_CLIENT'])
            ->setFirstName("cage")
            ->setBirthday(new \DateTime("1983-06-15"));
        $passwordUser5 = $passwordHasher->hashPassword($user5,'vador');
        $user5->setPassword($passwordUser5);
        $em->persist($user5);

        $em->flush();

        return $this->render("/layouts/Accueil.html.twig");
    }


    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN')"
    )]
    #[Route('/suppUser/{id}',
        name: '_suppUser',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function suppUser(int $id, EntityManagerInterface $em):Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($id);

        $name = $user->getName();

        if (is_null($user))
            throw new NotFoundHttpException("product deletion error " . $name);

        $em->remove($user);
        $em->flush();
        $this->addFlash('info', "user deleted " . $name . " successfully");

        return $this->redirectToRoute('vente_listUser');
    }

    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN')"
    )]
    #[Route('/listUser', name: '_listUser')]
    public function listUsersAction(EntityManagerInterface $em): Response
    {
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->findAll();
        $args = array(
            'users' => $users,
        );
        return $this->render('user/list.html.twig', $args);
    }
}
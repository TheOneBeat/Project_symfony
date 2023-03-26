<?php

namespace App\Controller\Vente;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/vente', name: 'vente')]
class SecurityTestController extends AbstractController
{
    #[Route('/addUsers', name: '_addUsers')]
    public function addUsers(EntityManagerInterface $em,
                             UserPasswordHasherInterface $passwordHasher):Response
    {

        $user1 = new User();
        $user1
            ->setLogin('mistress')
            ->setName("Rita")
            ->setRoles(['ROLE_CLIENT'])
            ->setFirstName("Zouri")
            ->setBirthday(new \DateTime());
        $passwordUser1 = $passwordHasher->hashPassword($user1,'atir');
        $user1->setPassword($passwordUser1);
        $em->persist($user1);


        //============================================

        $user2 = new User();
        $user2
            ->setLogin('theOne')
            ->setName("Bill")
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName("Gate")
            ->setBirthday(new \DateTime("2000-11-27"));
        $passwordUser2 = $passwordHasher->hashPassword($user2,'billyboy');
        $user2->setPassword($passwordUser2);
        $em->persist($user2);

        $em->flush();

        return $this->render("<body><h1>Very Good</h1></body>");
    }
}

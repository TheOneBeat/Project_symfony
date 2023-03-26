<?php

namespace App\Controller\Vente;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: '')]
class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function welcome(): Response
    {
        return $this->render("/layouts/menu.html.twig");
    }
}

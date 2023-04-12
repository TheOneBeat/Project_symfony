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
        if ($this->isGranted("ROLE_ADMIN") or $this->isGranted("ROLE_CLIENT"))
        {
            return $this->redirectToRoute('produit_listProduit');
        }
        return $this->render("/layouts/Accueil.html.twig");
    }

    #[Route('/welcomeH', name: 'accueilH')]
    public function welcomeH(): Response
    {
        return $this->render("/layouts/Accueil.html.twig");
    }
}

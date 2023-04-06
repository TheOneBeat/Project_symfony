<?php

namespace App\Controller\Vente;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('produit', name: 'produit')]
class ProduitController extends AbstractController
{

    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN')"
    )]
    #[Route('/add', name: '_add')]
    public function addAction(EntityManagerInterface $em, Request $request): Response
    {
        $Produit = new Produit();
        $form = $this->createForm(ProduitType::class, $Produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($Produit);
            $em->flush();

            $this->addFlash('success', "product added successfully");

            return $this->redirectToRoute('produit_listProduit');
        }

        return $this->render('vente/produit.html.twig', [
            'produit' => $Produit,
            'form' => $form->createView(),
        ]);
    }

    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')"
    )]

    #[Route('/listProduit', name: '_listProduit')]
    public function listUsersAction(EntityManagerInterface $em): Response
    {
        $produitRepository = $em->getRepository(Produit::class);
        $Produits = $produitRepository->findAll();
        $args = array(
            'user'=>$this->getUser(),
            'panier'=>$this->getUser()->getPanier(),
            'produits' => $Produits,
        );
        return $this->render('vente/ProduitList.html.twig', $args);
    }


    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')"
    )]
    #[Route('/listPanier', name: '_listPanier')]
    public function listPanier(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $panier = $user->getPanier();
        if (!$panier)
            $panier = new Panier();
        $args = array(
            'panier' => $panier,
        );
        return $this->render('vente/panier.html.twig', $args);
    }


    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')"
    )]

    #[Route('/addProduitPanier/{id}', name: '_addProduitPanier')]
    public function addProduitToPanierAction(Request $request, EntityManagerInterface $em,
                                                     $id): Response
    {
        $quantity = $request->query->get('quantity');
        $user = $this->getUser();
        $panier = $em->getRepository(Panier::class)->findOneBy(['user' => $user]);
        if (!$panier) {
            $panier = new Panier();
            $panier->setUser($user);
            $user->setPanier($panier);
            $em->persist($panier);
            $em->flush();
        }

        $theQuantity = intval($quantity);

        $produit = $em->getRepository(Produit::class)->find($id);
        $oldValue = $produit->getEnstock()- $theQuantity;//ce que j'ai rajoutée mais pas sûr...
        if ($oldValue<0)
            $oldValue=0;
        // Si le produit n'existe pas, rediriger l'utilisateur vers la page d'erreur
        if (!$produit)
        {
            throw $this->createNotFoundException("the product doesn't exist\n");
        }

        $produit->setEnstock($oldValue);//je remet à jour la quantité de produit restant pour ce type de produit...

        $panier->addProduit($produit, $theQuantity);
        $em->flush();
        return $this->redirectToRoute('produit_listProduit');
    }

    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')"
    )]
   #[Route('/viderPanier', name: '_viderPanier')]
    public function ViderPanierAction(EntityManagerInterface $em): Response
    {
        $user=  $this->getUser();//accès à l'utlisateur
        $panier = $em->getRepository(Panier::class)->findOneBy(['user' => $user]);//accès au panier de l'utlisateur
        if (!$panier) {
            return $this->redirectToRoute('produit_listPanier');
        }
        else
        {
            //$produitRepository = $em->getRepository(Produit::class);
            $Produits = $panier->getProduits()->toArray(null, true);
            foreach ($Produits as $Produit)
            {

                //si j'ai ce produit dans la liste des produit du panier...
                //$panier->getTableProduitQuantites() retourne la collection de l'entité panier qui contient chaque produit ajouté avec sa quantité...

                if (array_key_exists($Produit->getId(),$panier->getTableProduitQuantites()))//si j'ai ce produit dans la liste des produit du panier...
                    $Produit->setEnstock($Produit->getEnstock()+$panier->getQuantity($Produit->getId()));
                    //Ici je vide le panier en remettant (ajoutant) dans le produit de base, le stock qui a été pris ...
            }
            //$em->flush();
        }
        $produits = $panier->getProduits()->toArray(null, true);//tranforme la collection en array...
        foreach($produits as $produit)
        {
            $panier->removeProduit($produit);//Ici je vide le panier...
        }
        //Mais évidemment je ne détruis pas le panier...
        $em->flush();
        return $this->redirectToRoute('produit_listPanier');
    }

    #[\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security
    ("is_granted('ROLE_ADMIN') or is_granted('ROLE_CLIENT')"
    )]

    #[Route('/acheterPanier', name: '_acheterPanier')]
    public function AcheterPanierAction(EntityManagerInterface $em): Response
    {
        //L'idée c'est que pour acheter, on vide juste le panier sans remettre le stock pris dans le enstock du prosuit
        // en question
        $user=  $this->getUser();//accès à l'utlisateur
        $panier = $em->getRepository(Panier::class)->findOneBy(['user' => $user]);//accès au panier de l'utlisateur
        if (!$panier)
        {
            return $this->redirectToRoute('produit_listPanier');
        }
        else
        {
            $produits = $panier->getProduits()->toArray(null, true);//tranforme la collection en array...
            foreach($produits as $produit)
            {
                $panier->removeProduit($produit);
            }
            $em->flush();
        }

        return $this->redirectToRoute('produit_listPanier');
    }
}
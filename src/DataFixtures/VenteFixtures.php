<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VenteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $product1 = new produit();
        $product1
            ->setLibelle('veste')
            ->setPrix('65.5')
            ->setEnstock('10');

        $manager->persist($product1);

        //===========================================

        $product2 = new produit();
        $product2
            ->setLibelle('sweat')
            ->setPrix('29.99')
            ->setEnstock('3');


        $manager->persist($product2);

        $manager->flush();
    }
}

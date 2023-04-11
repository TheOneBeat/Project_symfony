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
            ->setLibelle('T-shirt')
            ->setPrix('24.99')
            ->setEnstock('7');

        $manager->persist($product1);

        //------------------------------

        $product2 = new produit();
        $product2
            ->setLibelle('Jean')
            ->setPrix('59.99')
            ->setEnstock('4');

        $manager->persist($product2);

        //------------------------------

        $product3 = new produit();
        $product3
            ->setLibelle('Hoodie')
            ->setPrix('45')
            ->setEnstock('3');

        $manager->persist($product3);

        //------------------------------


        $product4 = new produit();
        $product4
            ->setLibelle('Jacket')
            ->setPrix('80')
            ->setEnstock('10');

        $manager->persist($product4);

        //------------------------------


        $product5 = new produit();
        $product5
            ->setLibelle('Sweater')
            ->setPrix('39.99')
            ->setEnstock('8');

        $manager->persist($product5);

        //------------------------------


        $product6 = new produit();
        $product6
            ->setLibelle('Skirt')
            ->setPrix('35.00')
            ->setEnstock('2');

        $manager->persist($product6);

        //------------------------------

        /*
        $product7 = new produit();
        $product7
            ->setLibelle('Dress')
            ->setPrix('70.15')
            ->setEnstock('11');

        $manager->persist($product7);
        //------------------------------

        $product8 = new produit();
        $product8
            ->setLibelle('Shorts')
            ->setPrix('20')
            ->setEnstock('12');

        $manager->persist($product8);
        //------------------------------

        $product9 = new produit();
        $product9
            ->setLibelle('Socks')
            ->setPrix('5')
            ->setEnstock('8');

        $manager->persist($product9);
        //------------------------------

        $product10 = new produit();
        $product10
            ->setLibelle('Scarf ')
            ->setPrix('99')
            ->setEnstock('1');

        $manager->persist($product10);
        //------------------------------
        */

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::

        // Création des Etat
        $Etat1 = new Etat();
        $Etat1->setLibelle("En création");

        $Etat2 = new Etat();
        $Etat2->setLibelle("Ouverte");

        $Etat3 = new Etat();
        $Etat3->setLibelle("Clôturée");

        $Etat4 = new Etat();
        $Etat4->setLibelle("Activité en cours");

        $Etat5 = new Etat();
        $Etat5->setLibelle("Activité terminée");

        $Etat6 = new Etat();
        $Etat6->setLibelle("Activité historisée");

        $Etat7 = new Etat();
        $Etat7->setLibelle("Annulée");

        // Création des Ville
        for ($i=1; $i <= 10; $i++){
            $ville = new Ville();
            $ville->setNom();
        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

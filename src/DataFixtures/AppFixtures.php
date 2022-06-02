<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this-> hasher = $userPasswordHasher;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        // Création Etat
        $Etat1 = new Etat();
        $Etat1->setLibelle("En création");
        $Etat1->setCode("CREA");
        $manager->persist($Etat1);

        $Etat2 = new Etat();
        $Etat2->setLibelle("Ouverte");
        $Etat2->setCode("O");
        $manager->persist($Etat2);

        $Etat3 = new Etat();
        $Etat3->setLibelle("Clôturée");
        $Etat3->setCode("CLO");
        $manager->persist($Etat3);

        $Etat4 = new Etat();
        $Etat4->setLibelle("Activité en cours");
        $Etat4->setCode("AEC");
        $manager->persist($Etat4);

        $Etat5 = new Etat();
        $Etat5->setLibelle("Activité terminée");
        $Etat5->setCode("AT");
        $manager->persist($Etat5);

        $Etat6 = new Etat();
        $Etat6->setLibelle("Activité historisée");
        $Etat6->setCode("AH");
        $manager->persist($Etat6);

        $Etat7 = new Etat();
        $Etat7->setLibelle("Annulée");
        $Etat6->setCode("AN");
        $manager->persist($Etat7);

        //Création Campus
        $Campus1 = new Campus();
        $Campus1->setNom("Nantes");
        $manager->persist($Campus1);

        $Campus2 = new Campus();
        $Campus2->setNom("Rennes");
        $manager->persist($Campus2);

        $Campus3 = new Campus();
        $Campus3->setNom("Quimper");
        $manager->persist($Campus3);

        $Campus4 = new Campus();
        $Campus4->setNom("Niort");
        $manager->persist($Campus4);


        $manager->flush();

    $this->villes($manager);
    $this->lieux($manager);
    $this->Participants($manager);
    $this->Sortie($manager);
    $this->Admin($manager);


    }


        public function villes(ObjectManager $manager): void
        {
            // Création des Villes
            for ($i=1; $i <= 5; $i++){
                $ville = new Ville();
                $ville->setNom($this->faker->city)
                    ->setCodePostal((int)$this->faker->postcode);

                $manager->persist($ville);
            }
            $manager->flush();
        }

        public function lieux(ObjectManager $manager): void
        {
            $ville = $manager->getRepository(Ville::class)->findAll();

            // Création des lieux
            for ($j=1; $j <= 10; $j++){
                $lieu = new Lieu();
                $lieu->setNom($this->faker->word)
                    ->setRue($this->faker->streetName)
                    ->setLatitude((int)$this->faker->latitude($min = -90, $max = 90))
                    ->setLongitude((int)$this->faker->longitude($min = -180, $max = 180))
                    ->setVille($this->faker->randomElement($ville));

                $manager->persist($lieu);
            }
            $manager->flush();
        }

        public function Participants(ObjectManager $manager): void
        {
            $campus = $manager->getRepository(Campus::class)->findAll();

            // Création des participants
            for ($j=1; $j <= 20; $j++){

                $plainTextPassword = $this->faker->password;

                $participant = new Participant();
                $participant->setPrenom($this->faker->firstName($gender = null))
                ->setNom($this->faker->lastName)
                ->setTelephone($this->faker->phoneNumber())
                ->setEmail($this->faker->email)
                ->setActif($this->faker->boolean($chanceOfGettingTrue = 50))
                ->setCampus($this->faker->randomElement($campus))
                    ->setPseudo($this->faker->word)
                ->setPassword(
                    $this->hasher->hashPassword(
                        $participant,
                        $plainTextPassword
                    ));

                $manager->persist($participant);
            }
            $manager->flush();
        }

        public function Sortie(ObjectManager $manager): void{

            // Création des sorties
        $etat = $manager->getRepository(Etat::class)->findAll();
        $lieu = $manager->getRepository(Lieu::class)->findAll();
        $campus = $manager->getRepository(Campus::class)->findAll();
        $participant = $manager->getRepository(Participant::class)->findAll();

            for ($x=1; $x <= 15; $x++){
                $sortie = new Sortie();
                $debut = $this->faker->dateTimeBetween('-6 months');
                $sortie->setNom($this->faker->word)
                    ->setDateHeureDebut($debut)
                    ->setDuree($this->faker->numberBetween(10, 50))
                    ->setDateLimiteInscription($this->faker->dateTimeBetween($startDate = $debut, $endDate = 'now'))
                    ->setNbInscriptionsMax($this->faker->numberBetween(0,150))
                    ->setInfosSortie(join(" ", $this->faker->words(10)))
                    ->setEtat($this->faker->randomElement($etat))
                    ->setLieu($this->faker->randomElement($lieu))
                    ->setCampus($this->faker->randomElement($campus))
                    ->setOrganisateur($this->faker->randomElement($participant))
                    ->addLstParticipant($sortie->getOrganisateur());

                    for ($q=1; $q <= $sortie->getNbInscriptionsMax(); $q++){
                        $sortie->addLstParticipant($this->faker->randomElement($participant));
                    }

                $manager->persist($sortie);
            }
            $manager->flush();
        }

    public function Admin(ObjectManager $manager): void
    {
        $campus = $manager->getRepository(Campus::class)->findAll();

        // Création de jonas

            $plainTextPassword = "Jonas35";

            $admin = new Participant();
            $admin->setPrenom($this->faker->firstName($gender = null))
                ->setNom($this->faker->lastName)
                ->setTelephone($this->faker->phoneNumber())
                ->setEmail("Jonas@gmail.com")
                ->setActif($this->faker->boolean($chanceOfGettingTrue = 50))
                ->setCampus($this->faker->randomElement($campus))
                ->setPseudo("Jonas")
                ->setPassword(
                    $this->hasher->hashPassword(
                        $admin,
                        $plainTextPassword
                    ));
            $manager->persist($admin);
            $manager->flush();

        // Création de Cedric

        $plainTextPassword = "Cedric357";

        $admin = new Participant();
        $admin->setPrenom($this->faker->firstName($gender = null))
            ->setNom($this->faker->lastName)
            ->setTelephone($this->faker->phoneNumber())
            ->setEmail("Cedric@gmail.com")
            ->setActif($this->faker->boolean($chanceOfGettingTrue = 50))
            ->setCampus($this->faker->randomElement($campus))
            ->setPseudo("Cedric")
            ->setPassword(
                $this->hasher->hashPassword(
                    $admin,
                    $plainTextPassword
                ));
        $manager->persist($admin);
        $manager->flush();

        // Création de Arthur

        $plainTextPassword = "Arthur2";

        $admin = new Participant();
        $admin->setPrenom($this->faker->firstName($gender = null))
            ->setNom($this->faker->lastName)
            ->setTelephone($this->faker->phoneNumber())
            ->setEmail("Arthur@gmail.com")
            ->setActif($this->faker->boolean($chanceOfGettingTrue = 50))
            ->setCampus($this->faker->randomElement($campus))
            ->setPseudo("Arthur")
            ->setPassword(
                $this->hasher->hashPassword(
                    $admin,
                    $plainTextPassword
                ));
        $manager->persist($admin);
        $manager->flush();

        // Création de Sylvain

        $plainTextPassword = "Sylvain1";

        $admin = new Participant();
        $admin->setPrenom($this->faker->firstName($gender = null))
            ->setNom($this->faker->lastName)
            ->setTelephone($this->faker->phoneNumber())
            ->setEmail("Sylvain@gmail.com")
            ->setActif($this->faker->boolean($chanceOfGettingTrue = 50))
            ->setCampus($this->faker->randomElement($campus))
            ->setPseudo("SylvainLeBoss")
            ->setPassword(
                $this->hasher->hashPassword(
                    $admin,
                    $plainTextPassword
                ));
        $manager->persist($admin);
        $manager->flush();
    }
}





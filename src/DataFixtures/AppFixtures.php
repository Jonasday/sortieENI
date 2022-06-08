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
use Doctrine\Common\Collections\ArrayCollection;
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
        $etat1 = new Etat();
        $etat1->setLibelle("En création");
        $etat1->setCode("CREA");
        $manager->persist($etat1);

        $etat2 = new Etat();
        $etat2->setLibelle("Ouverte");
        $etat2->setCode("O");
        $manager->persist($etat2);

        $etat3 = new Etat();
        $etat3->setLibelle("Clôturée");
        $etat3->setCode("CLO");
        $manager->persist($etat3);

        $etat4 = new Etat();
        $etat4->setLibelle("Activité en cours");
        $etat4->setCode("AEC");
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle("Activité terminée");
        $etat5->setCode("AT");
        $manager->persist($etat5);

        $etat6 = new Etat();
        $etat6->setLibelle("Activité historisée");
        $etat6->setCode("AH");
        $manager->persist($etat6);

        $etat7 = new Etat();
        $etat7->setLibelle("Annulée");
        $etat7->setCode("AN");
        $manager->persist($etat7);

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
                ->setImage('Avatar.jpg')
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

        $tableSortie = ['Bowling', 'Bar', 'Tournoi de foot', 'Baseball', 'Sieste collective',
            'Soirée chez moi', 'Spectacle de lumière', 'Théâtre', 'Cinema', 'Basketball',
            'Piscine', 'Aquagym', 'Poney Club', 'Concert', 'Karting', 'Soccer', 'Speed Dating',
            'Restaurant', 'Barbecue', 'Poker'];

            // Création des sorties
        $etat = $manager->getRepository(Etat::class)->findAll();
        $lieu = $manager->getRepository(Lieu::class)->findAll();
        $campus = $manager->getRepository(Campus::class)->findAll();
        $participant = $manager->getRepository(Participant::class)->findAll();

            for ($x=1; $x <= 30; $x++){
                $sortie = new Sortie();
                $duree = $this->faker->numberBetween(10, 60);
                $debut = $this->faker->dateTimeBetween('-1 months', '+2 week');
                $debutDeFin = $debut->modify('- 5 days');

                $sortie->setNom($this->faker->randomElement($tableSortie))
                    ->setDateHeureDebut($debut)
                    ->setDuree($duree)
                    ->setDateLimiteInscription($this->faker->dateTimeBetween($startDate = $debutDeFin, $endDate = $debut->modify('- 1 days')))
                    ->setNbInscriptionsMax($this->faker->numberBetween(0,20))
                    ->setInfosSortie(join(" ", $this->faker->words(10)))
                    ->setEtat($this->faker->randomElement($etat))
                    ->setLieu($this->faker->randomElement($lieu))
                    ->setCampus($this->faker->randomElement($campus))
                    ->setOrganisateur($this->faker->randomElement($participant))
                    ->setLstParticipant(new ArrayCollection($this->faker->randomElements($participant,$sortie->getNbInscriptionsMax()-1)));

                $manager->persist($sortie);
            }
            $manager->flush();
        }

    public function Admin(ObjectManager $manager): void
    {
        $campus = $manager->getRepository(Campus::class)->findAll();

        // Création de Jonas

            $plainTextPassword = "Jonas35";

            $admin = new Participant();
            $admin->setPrenom($this->faker->firstName($gender = null))
                ->setNom($this->faker->lastName)
                ->setTelephone($this->faker->phoneNumber())
                ->setEmail("Jonas@gmail.com")
                ->setActif($this->faker->boolean($chanceOfGettingTrue = 50))
                ->setCampus($this->faker->randomElement($campus))
                ->setPseudo("Jonas")
                ->setImage('Avatar.jpg')
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
            ->setImage('Avatar.jpg')
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
            ->setImage('Avatar.jpg')
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
            ->setImage('Avatar.jpg')
            ->setPassword(
                $this->hasher->hashPassword(
                    $admin,
                    $plainTextPassword
                ));
        $manager->persist($admin);
        $manager->flush();
    }
}





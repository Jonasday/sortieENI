<?php

namespace App\Commande;

use App\Entity\Sortie;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class EtatSortieUpdate
{

    private SortieRepository $sortieRepository;
    private EtatRepository $etatRepository;

    public function __construct(SortieRepository $sortieRepository, EntityManagerInterface $em,EtatRepository $etatRepository){
        $this-> sortieRepository = $sortieRepository;
        $this-> etatRepository = $etatRepository;
        $this-> entityManagerInterface = $em;

    }

    public function update(): void
    {
        $lstSortie = $this->sortieRepository->findAll();
        $dateDuJours = new \DateTime();
        $dateHistorisee = new \DateTime('-1 month');


        foreach ($lstSortie as $item) {
            dump($item);

            $currentEtat = $item->getEtat()->getCode();
            $currentDateHeureDebut = $item->getDateHeureDebut();
            $currentDuree = $item->getDuree();
            $currentDateLimiteInscription = $item->getDateLimiteInscription();
            $currentNbInscriptionMax = $item->getNbInscriptionsMax();
            $currentLstInscript = $item->getLstParticipant();

            if ($currentEtat != "CREA" && sizeof($currentLstInscript)>=$currentNbInscriptionMax && $dateDuJours > $currentDateLimiteInscription){
                $etatCloturee = $this->etatRepository->findOneBy(['code' => 'CLO']);
                $item->setEtat($etatCloturee);
            }
            if ($currentEtat != "CREA" && $dateDuJours < $currentDateHeureDebut->modify($currentDuree.' minutes') && $dateDuJours > $currentDateHeureDebut ){
                $etatAEC = $this->etatRepository->findOneBy(['code' => 'AEC']);
                $item->setEtat($etatAEC);
            }
            if ($currentEtat != "CREA" && $dateDuJours > ($currentDateHeureDebut->modify($currentDuree.' minutes')) && $currentDateHeureDebut < $dateHistorisee ){
                $etatAT = $this->etatRepository->findOneBy(['code' => 'AT']);
                $item->setEtat($etatAT);
            }
            if ($currentDateHeureDebut > $dateHistorisee ){
                $etatAH = $this->etatRepository->findOneBy(['code' => 'AH']);
                $item->setEtat($etatAH);
            }

            $this->entityManagerInterface->persist($item);
            $this->entityManagerInterface->flush();

        }




    }


}
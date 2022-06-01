<?php

namespace App\Commande;

use App\Entity\Sortie;
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

    public function __construct(SortieRepository $sortieRepository, EntityManagerInterface $em){
        $this-> sortieRepository = $sortieRepository;
        $this-> entityManagerInterface = $em;

    }

    public function update(): void
    {
//        $lstSortie = $this->sortieRepository->findAll();
//        $dateDuJours = time();
//        $mois = mktime(0,0,0,1,0,0,);
//        $dateTest = $dateDuJours + $mois;
//        dump($dateDuJours);
//        dump($dateTest);
//
//
//        foreach ($lstSortie as $item) {
//            dump($item);
//
//            $currentEtat = $item->getEtat();
//            $currentDateHeureDebut = $item->getDateHeureDebut();
//            $currentDuree = $item->getDuree();
//            $currentDateLimiteInscription = $item->getDateLimiteInscription();
//            $currentNbInscriptionMax = $item->getNbInscriptionsMax();
//            $currentLstInscript = $item->getLstParticipant();
//
//            if ($currentEtat != "En création" and count($currentLstInscript)<$currentNbInscriptionMax and $dateDuJours <= $currentDateLimiteInscription){
//                $item->setEtat("Ouverte");
//            }
//            if ($currentEtat != "En création" and count($currentLstInscript)>=$currentNbInscriptionMax and $dateDuJours > $currentDateLimiteInscription){
//                $item->setEtat("Clôturée");
//            }
//            if ($currentEtat != "En création" and $dateDuJours > $currentDateHeureDebut ){
//                $item->setEtat("Activité en cours");
//            }
//            if ($currentEtat != "En création" and $dateDuJours > ($currentDateHeureDebut+$currentDuree) ){
//                $item->setEtat("Activité terminée");
//            }
//
//            $this->entityManagerInterface->persist($item);
//            $this->entityManagerInterface->flush();

//            if ($currentDateHeureDebut < $dateDuJours ){
//                $item->setEtat("Activité en historisée");
//            }

//        }




    }


}
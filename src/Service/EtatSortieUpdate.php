<?php

namespace App\Service;

use App\Entity\Sortie;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class EtatSortieUpdate
{

    private SortieRepository $sortieRepository;
    private EtatRepository $etatRepository;

    public function __construct(SortieRepository $sortieRepository, EntityManagerInterface $em, EtatRepository $etatRepository)
    {
        $this->sortieRepository = $sortieRepository;
        $this->etatRepository = $etatRepository;
        $this->entityManagerInterface = $em;

    }

    public function update(): void
    {
        $lstSortie = $this->sortieRepository->customQuerryUpdate();
        $lstEtat = $this->etatRepository->findAll();

        foreach ($lstEtat as $item) {
            if ($item->getCode() == "O"){
                $etatopen = $item;
            }
            if ($item->getCode() == "CLO"){
                $etatclosed = $item;
            }
            if ($item->getCode() == "AEC"){
                $etatOngoing = $item;
            }
            if ($item->getCode() == "AT"){
                $etatEnd = $item;
            }
            if ($item->getCode() == "AH"){
                $etatArchived = $item;
            }


        }

        foreach ($lstSortie as $item) {

            if ($this->updateToClosed($item)) {
                $item->setEtat($etatclosed);
            }

            if ($this->updateToOpen($item)) {
                $item->setEtat($etatopen);
            }

            if ($this->updateToOngoingActivity($item)) {
                $item->setEtat($etatOngoing);
            }

            if ($this->updateToEndActivity($item)) {
                $item->setEtat($etatEnd);
            }

            if ($this->updateToArchivedActivitiy($item)) {
                $item->setEtat($etatArchived);
            }

            $this->entityManagerInterface->persist($item);
            $this->entityManagerInterface->flush();
        }

    }

    public function updateToOpen($sortie)
    {
        $now = new \DateTime();

        if ($sortie->getEtat()->getCode() === "CLO" &&
            $sortie->getDateLimiteInscription() > $now &&
            $sortie->getEtat()->getCode() !== "O" &&
            $sortie->getDateHeureDebut() > $now &&
            sizeof($sortie->getLstParticipant()) < $sortie->getNbInscriptionsMax()
        ) {
            return true;
        }
        return false;
    }

    public function updateToClosed(Sortie $sortie)
    {
        $now = new \DateTime();

        if ($sortie->getEtat()->getCode() === "O" &&
            $sortie->getDateLimiteInscription() <= $now &&
            $sortie->getEtat()->getCode() !== "CLO" ||
            sizeof($sortie->getLstParticipant()) >= $sortie->getNbInscriptionsMax()
        ) {
            return true;
        }
        return false;
    }

    public function updateToOngoingActivity($sortie)
    {
        $now = new \DateTime();
        $BegingDateSortie = clone $sortie->getDateHeureDebut();

        if ($sortie->getEtat()->getCode() === "CLO" &&
            $sortie->getEtat()->getCode() !== "AEC" &&
            $sortie->getDateHeureDebut() < $now &&
            $BegingDateSortie->modify($sortie->getDuree() . ' minutes') > $now
        ) {
            return true;
        }
        return false;
    }

    public function updateToEndActivity($sortie)
    {
        $now = new \DateTime();
        $BegingDateSortie = clone $sortie->getDateHeureDebut();

        if ($sortie->getEtat()->getCode() === "AEC" &&
            $sortie->getEtat()->getCode() !== "AT" &&
            $BegingDateSortie->modify($sortie->getDuree() . ' minutes') < $now
        ) {
            return true;
        }
        return false;
    }

    public function updateToArchivedActivitiy($sortie)
    {
        $BegingDateSortie = clone $sortie->getDateHeureDebut();
        $ArchivedActivitiyDate = new \DateTime('-1 month');
        $EndDateSortie = $BegingDateSortie->modify($sortie->getDuree() . ' minutes');

        if ($sortie->getEtat()->getCode() !== "AH" &&
            $EndDateSortie < $ArchivedActivitiyDate
        ) {
            return true;
        }
        return false;
    }

}
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
        $lstSortie = $this->sortieRepository->findAll();
        $etatclosed = $this->etatRepository->findOneBy(['code' => 'CLO']);
        $etatOngoing = $this->etatRepository->findOneBy(['code' => 'AEC']);
        $etatEnd = $this->etatRepository->findOneBy(['code' => 'AT']);
        $etatArchived = $this->etatRepository->findOneBy(['code' => 'AH']);


        foreach ($lstSortie as $item) {

            if ($this->updateToClosed($item)) {
                $item->setEtat($etatclosed);
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


    public function updateToClosed(Sortie $sortie)
    {
        $now = new \DateTime();

        if ($sortie->getEtat()->getCode() === "O" &&
            $sortie->getDateLimiteInscription() <= $now &&
            $sortie->getEtat()->getCode() !== "CLO" &&
            $sortie->getDateHeureDebut() > $now
        ) {
            return true;
        }
        return false;
    }

    public function updateToOngoingActivity(Sortie $sortie)
    {
        $now = new \DateTime();

        if ($sortie->getEtat()->getCode() === "CLO" &&
            $sortie->getEtat()->getCode() !== "AEC" &&
            $sortie->getDateHeureDebut() < $now &&
            $sortie->getDateLimiteInscription()->modify($sortie->getDuree() . ' minutes') >= $now
        ) {
            return true;
        }
        return false;
    }

    public function updateToEndActivity(Sortie $sortie)
    {
        $now = new \DateTime();

        if ($sortie->getEtat()->getCode() === "AEC" &&
            $sortie->getEtat()->getCode() !== "AT" &&
            $sortie->getDateLimiteInscription()->modify($sortie->getDuree() . ' minutes') < $now
        ) {
            return true;
        }
        return false;
    }

    public function updateToArchivedActivitiy(Sortie $sortie)
    {
        $ArchivedActivitiyDate = new \DateTime('-1 month');
        $endActivityDate = $sortie->getDateLimiteInscription()->modify($sortie->getDuree() . ' minutes');

        if ($sortie->getEtat()->getCode() !== "AH" &&
            $endActivityDate < $ArchivedActivitiyDate
        ) {
            return true;
        }
        return false;
    }

}
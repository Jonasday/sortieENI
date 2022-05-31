<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Response\HttplugPromise;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    public function addProfile (ParticipantRepository $participantRepository) : Response
    //public function add() : Response
    {
        $participant = new Participant();
        $participant->setNom()
                    ->setPrenom()
                    ->setTelephone()
                    ->setEmail()
                    ->setPassword()
                    ->setActif();

        $participantRepository->add($participant, true);
        echo "enregistrement effectué";
        die();

    }

}

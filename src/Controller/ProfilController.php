<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\CreateProfileType;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Response\HttplugPromise;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function modifyProfile(): Response
    {

        $form = $this->createForm(CreateProfileType::class, $this->getUser());

        return $this->render('profil/createprofile.html.twig', [
            'controller_name' => 'ProfilController',
            'form' => $form-> createView()
        ]);

    }
    #[Route('/research/{id}', 'research')]
    public function ResearchOtherProfliles($id, ParticipantRepository $participantRepository): Response
    {
        $profil=$participantRepository->find($id);

        return $this->render('profil/research_other_profiles.html.twig', [
            'id' => $id,
            'profil' => $profil
        ]);
    }

}


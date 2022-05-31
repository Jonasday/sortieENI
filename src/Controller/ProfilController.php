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
        $form = $this->createForm(CreateProfileType::class);

        return $this->render('profil/createprofile.html.twig', [
            'controller_name' => 'ProfilController',
            'form' => $form-> createView()
        ]);






        }




}

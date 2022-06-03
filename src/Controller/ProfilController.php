<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\CreateProfileType;
use App\Repository\ParticipantRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;

use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function modifyProfile(Request $request , EntityManagerInterface $entityManager, FileUploader $fileUploader, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $currentParticipant = $this->getUser();
        $form = $this->createForm(CreateProfileType::class,$currentParticipant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //$imageFile = l'image à upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile){

                $imageFileName = $fileUploader->upload($imageFile);

                $currentParticipant->setImage($imageFileName);

            }

            $plainPassword = $form->get('password')['first']->getData();

            if ($plainPassword){
                $hashedPassword = $userPasswordHasher->hashPassword($currentParticipant, $plainPassword);
                $currentParticipant->setPassword($hashedPassword);
            }




            $entityManager->persist($currentParticipant);
            $entityManager->flush();
            //Si formulaire valider je redirige
            return $this->redirectToRoute("home");

        }

        return $this->render('profil/createprofile.html.twig', [
            'form' => $form-> createView()
        ]);

    }

    #[Route('/research/{id}', name : 'profil_research')]
    public function ResearchOtherProfliles($id, ParticipantRepository $participantRepository): Response
    {
        $profil=$participantRepository->find($id);

        if(!$profil){
            throw $this->createNotFoundException("Le profile recherché n'existe pas");
        }

        return $this->render('profil/research_other_profiles.html.twig', [
            'profil' => $profil
        ]);
    }

}


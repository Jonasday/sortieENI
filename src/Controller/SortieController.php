<?php

namespace App\Controller;

use App\Service\EtatSortieUpdate;
use App\Entity\Campus;
use App\Entity\Sortie;
use App\Form\CancelActivityType;
use App\Form\CreateActivityType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    # Créer une sortie
    #[Route('/create_sortie', name: 'create_sortie')]
    public function createActivity(Request $request, SortieRepository $sortieRepository, EtatRepository $etatRepository): Response
    {
        $sortie = new Sortie();
        $user = $this->getUser();
        $sortie->setCampus($user->getCampus());

        $form = $this->createForm(createActivityType::class, $sortie);

        #Pour récupérer le bouton du twig
        //$saveButton = $request->get('checkpoint');
        //$publishButton = $request->get('publish');

        #Pour récupérer le bouton du FormType
//        $saveButton = $form->get('checkpoint')->isClicked();
//        $publishButton = $form->get('publish')->isClicked();

        $sortie->setOrganisateur($user);
        $sortie->setCampus($user->getCampus());
        $sortie->addLstParticipant($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('checkpoint')->isClicked()) {
                $etat = $etatRepository->findOneBy(['code' => 'CREA']);
                $sortie->setEtat($etat);
                $sortieRepository->add($sortie, true);
                return $this->redirectToRoute('home');
            }

            if ($form->get('publish')->isClicked()) {
                $etat = $etatRepository->findOneBy(['code' => 'O']);
                $sortie->setEtat($etat);
                $sortieRepository->add($sortie, true);
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('sortie/create_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView()
        ]);
    }

    #Afficher une sortie
    #[Route('/display_sortie/{id}', name: 'display_sortie')]
    public function displayActivity($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $lstParticipant = $sortie->getLstParticipant();

        return $this->render('sortie/display_sortie.html.twig', [
            'id' => $id,
            'sortie' => $sortie,
            'lstParticipant' => $lstParticipant
        ]);

    }

    #Modifier une sortie
    #[Route('/modify_sortie/{id}', name: 'modify_sortie')]
    public function modifyActivity($id, Request $request, SortieRepository $sortieRepository, EtatRepository $etatRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        $form = $this->createForm(createActivityType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('checkpoint')->isClicked()) {
                $etat = $etatRepository->findOneBy(['code' => 'CREA']);
                $sortie->setEtat($etat);
                $sortieRepository->add($sortie, true);
            }

            if ($form->get('publish')->isClicked()) {
                $etat = $etatRepository->findOneBy(['code' => 'O']);
                $sortie->setEtat($etat);
                $sortieRepository->add($sortie, true);
            }

        }
        return $this->render('sortie/modify_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView(),
            'id' => $id,
            'sortie' => $sortie
        ]);

    }

    #Annuler une sortie
    #[Route('/cancel_sortie/{id}', name: 'cancel_sortie')]
    public function cancelActivity($id, Request $request, SortieRepository $sortieRepository, EtatRepository $etatRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        $form = $this->createForm(cancelActivityType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('delete')->isClicked()) {
                $etatRepository->findOneBy(['code' => 'AN']);
                $sortie->removeLstParticipant($this->getUser());
                $motif = $form->getData();
                dump($motif);
                $sortie->setInfosSortie($sortie->getInfosSortie());

                $sortieRepository->add($sortie, true);
           }
        }

        return $this->render('sortie/cancel_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'id' => $id,
            'sortie' => $sortie,
            'form' => $form->createView()
        ]);
    }

    #Se désister une sortie
    #[Route('/desist_sortie/{id}', name: 'desist_sortie')]
    public function desistActivity($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->removeLstParticipant($this->getUser());
        $sortieRepository->add($sortie, true);

        return $this->render('sortie/desist_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'id' => $id,
            'sortie' => $sortie
        ]);
    }

    #S'inscrire une sortie
    #[Route('/register_sortie/{id}', name: 'register_sortie')]
    public function registerToActivity($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $sortie->addLstParticipant($this->getUser());
        $sortieRepository->add($sortie, true);

        return $this->render('sortie/register_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'id' => $id,
            'sortie' => $sortie
        ]);
    }

}

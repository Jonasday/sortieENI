<?php

namespace App\Controller;

use App\Commande\EtatSortieUpdate;
use App\Entity\Campus;
use App\Entity\Sortie;
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

        $form = $this->createForm(createActivityType::class, $sortie);

        $saveButton = $form->get('checkpoint');
        $publishButton = $form->get('publish');

        $currentuser = $sortie->setOrganisateur($this->getUser());
        $sortie->setCampus($currentuser->getCampus());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($saveButton->isClicked()) {
                $etat = $etatRepository->findOneBy(['code' => 'CREA']);
                $sortie->setEtat($etat);
                $sortieRepository->add($sortie, true);
                $this->addFlash("success", "La sortie a été enregitrée !");
            }

            if ($publishButton->isClicked()) {
                $etat = $etatRepository->findOneBy(['code' => 'O']);
                $sortie->setEtat($etat);
                $sortieRepository->add($sortie, true);
                $this->addFlash("success", "La sortie a été publiée !");
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

        return $this->render('sortie/display_sortie.html.twig', [
            'id' => $id,
            'sortie' => $sortie,
        ]);
    }

    #Modifier une sortie
    #[Route('/modify_sortie/{id}', name: 'modify_sortie')]
    public function modifyActivity($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $form = $this->createForm(createActivityType::class, $sortie);

        return $this->render('sortie/modify_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView(),
            'sortie' => $sortie
        ]);
    }

    #Annuler une sortie
    #[Route('/cancel_sortie/{id}', name: 'cancel_sortie')]
    public function cancelActivity($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('sortie/cancel_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'sortie' => $sortie
        ]);
    }

    #Se désister une sortie
    #[Route('/desist_sortie', name: 'desist_sortie')]
    public function desistActivity(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #S'inscrire une sortie
    #[Route('/desist_sortie', name: 'registre_sortie')]
    public function registreToActivity(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

}

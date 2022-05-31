<?php

namespace App\Controller;

use App\Form\CreateActivityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    # Créer une sortie
    #[Route('/create_sortie', name: 'create_sortie')]
    public function createActivity(): Response
    {
        $form = $this->createForm(createActivityType::class);

        return $this->render('sortie/create_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView()
        ]);
    }

    #Afficher une sortie
    #[Route('/display_sortie', name: 'display_sortie')]
    public function displayActivity(): Response
    {
        return $this->render('sortie/display_sortie.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #Modifier une sortie
    #[Route('/modify_sortie', name: 'modify_sortie')]
    public function modifyActivity(): Response
    {
        $form = $this->createForm(createActivityType::class);

        return $this->render('sortie/modify_sortie.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView()
        ]);
    }

    #Annuler une sortie
    #[Route('/cancel_sortie', name: 'cancel_sortie')]
    public function cancelActivity(): Response
    {
        return $this->render('sortie/cancel_sortie.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }
}

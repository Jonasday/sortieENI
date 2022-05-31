<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    # Créer une sortie
    #[Route('/sortie', name: 'app_sortie')]
    public function createActivity(): Response
    {
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #Afficher une sortie
    #[Route('/sortie', name: 'app_sortie')]
    public function displayActivity(): Response
    {
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #Modifier une sortie
    #[Route('/sortie', name: 'app_sortie')]
    public function modifyActivity(): Response
    {
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    #Annuler une sortie
    #[Route('/sortie', name: 'app_sortie')]
    public function cancelActivity(): Response
    {
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }
}

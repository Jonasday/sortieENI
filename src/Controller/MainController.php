<?php

namespace App\Controller;

use App\Commande\EtatSortieUpdate;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(EtatSortieUpdate $etatSortieUpdate): Response
    {
        $etatSortieUpdate->update();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}

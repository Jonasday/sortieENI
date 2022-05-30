<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {

        #coucou test !! Est-ce que tu vois ce message ? if(oui){ echo "Super"} if else { echo "Nooooon !"]

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}

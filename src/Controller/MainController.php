<?php

namespace App\Controller;

use App\Commande\EtatSortieUpdate;
use App\Form\FiltreSortieType;

use App\Form\Model\Search;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(Request $request, EtatSortieUpdate $etatSortieUpdate, SortieRepository $sortieRepository  ): Response
    {
        // Mise a jour des etat
//        $etatSortieUpdate->update();

        $search = new Search();
        $form = $this->createForm(FiltreSortieType::class, $search);

        //Envoie de toutes les sortie par défault
        $sortieArray = $sortieRepository->findAll();


        // Hydrater $search avec le retour de la requête de type POST
        $form->handleRequest($request);

//On vérifi que le form est bien rempli avec les bon type etc..
        if ($form->isSubmitted() && $form->isValid()){
            //Appeler la classe et la fonction pour le filtreSortie
            $sortieRepository->filterFormCustomQuery($search);


        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'sorties' => $sortieArray,

        ]);
    }
}

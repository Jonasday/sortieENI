<?php

namespace App\Controller;

use App\Service\EtatSortieUpdate;
use App\Entity\Campus;
use App\Form\FiltreSortieType;

use App\Form\Model\Search;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(Request $request, EtatSortieUpdate $etatSortieUpdate, SortieRepository $sortieRepository, EtatRepository $etatRepository  ): Response
    {
        // Mise a jour des etat
//        $etatSortieUpdate->update();

        $search = new Search();
        $currentuser = $this->getUser();
        $search ->setCampus($currentuser->getCampus());

        $form = $this->createForm(FiltreSortieType::class, $search);

        //Envoie de toutes les sortie par défault
        $sortieArray = $sortieRepository->filterFormCustomQuery($search,$currentuser,$etatRepository);


        // Hydrater $search avec le retour de la requête de type POST
        $form->handleRequest($request);

            //On vérifi que le form est bien rempli avec les bon type etc..
        if ($form->isSubmitted() && $form->isValid()){

            //Appeler la classe et la fonction pour le filtreSortie
            $sortieArray = $sortieRepository->filterFormCustomQuery($search,$currentuser,$etatRepository);

        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'sorties' => $sortieArray,

        ]);
    }
}

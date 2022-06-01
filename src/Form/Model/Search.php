<?php

namespace App\Form\Model;

use App\Entity\Campus;
use App\Model\nom;
use phpDocumentor\Reflection\Types\Boolean;

class Search
{

    private Campus $campus;
    private $motsClef;
    private $dateMin;
    private $dateMax;
    private Boolean $sortieOrganisateur;
    private Boolean $sortieInscrit;
    private Boolean $sortiePasInscrit;
    private Boolean $sortiePasse;


}
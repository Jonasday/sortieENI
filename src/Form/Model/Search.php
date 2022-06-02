<?php

namespace App\Form\Model;

use App\Entity\Campus;
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

    /**
     * @return Campus
     */
    public function getCampus(): Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus $campus
     * @return Search
     */
    public function setCampus(Campus $campus): Search
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMotsClef()
    {
        return $this->motsClef;
    }

    /**
     * @param mixed $motsClef
     * @return Search
     */
    public function setMotsClef($motsClef)
    {
        $this->motsClef = $motsClef;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateMin()
    {
        return $this->dateMin;
    }

    /**
     * @param mixed $dateMin
     * @return Search
     */
    public function setDateMin($dateMin)
    {
        $this->dateMin = $dateMin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateMax()
    {
        return $this->dateMax;
    }

    /**
     * @param mixed $dateMax
     * @return Search
     */
    public function setDateMax($dateMax)
    {
        $this->dateMax = $dateMax;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortieOrganisateur(): bool
    {
        return $this->sortieOrganisateur;
    }

    /**
     * @param bool $sortieOrganisateur
     * @return Search
     */
    public function setSortieOrganisateur(bool $sortieOrganisateur): Search
    {
        $this->sortieOrganisateur = $sortieOrganisateur;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortieInscrit(): bool
    {
        return $this->sortieInscrit;
    }

    /**
     * @param bool $sortieInscrit
     * @return Search
     */
    public function setSortieInscrit(bool $sortieInscrit): Search
    {
        $this->sortieInscrit = $sortieInscrit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortiePasInscrit(): bool
    {
        return $this->sortiePasInscrit;
    }

    /**
     * @param bool $sortiePasInscrit
     * @return Search
     */
    public function setSortiePasInscrit(bool $sortiePasInscrit): Search
    {
        $this->sortiePasInscrit = $sortiePasInscrit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortiePasse(): bool
    {
        return $this->sortiePasse;
    }

    /**
     * @param bool $sortiePasse
     * @return Search
     */
    public function setSortiePasse(bool $sortiePasse): Search
    {
        $this->sortiePasse = $sortiePasse;
        return $this;
    }


}
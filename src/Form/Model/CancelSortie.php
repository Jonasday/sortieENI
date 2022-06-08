<?php

namespace App\Form\Model;

class CancelSortie
{

    private $motif;

    /**
     * @return mixed
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * @param mixed $motif
     * @return CancelSortie
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;
        return $this;
    }



}
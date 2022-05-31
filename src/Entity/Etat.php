<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Sortie::class, orphanRemoval: true)]
    private $lstSortie;

    public function __construct()
    {
        $this->lstSortie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getLstSortie(): Collection
    {
        return $this->lstSortie;
    }

    public function addLstSortie(Sortie $lstSortie): self
    {
        if (!$this->lstSortie->contains($lstSortie)) {
            $this->lstSortie[] = $lstSortie;
            $lstSortie->setEtat($this);
        }

        return $this;
    }

    public function removeLstSortie(Sortie $lstSortie): self
    {
        if ($this->lstSortie->removeElement($lstSortie)) {
            // set the owning side to null (unless already changed)
            if ($lstSortie->getEtat() === $this) {
                $lstSortie->setEtat(null);
            }
        }

        return $this;
    }


}

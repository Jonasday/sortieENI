<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'integer')]
    private $codePostal;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Lieu::class, orphanRemoval: true)]
    private $lstLieu;

    public function __construct()
    {
        $this->lstLieu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, Lieu>
     */
    public function getLstLieu(): Collection
    {
        return $this->lstLieu;
    }

    public function addLstLieu(Lieu $lstLieu): self
    {
        if (!$this->lstLieu->contains($lstLieu)) {
            $this->lstLieu[] = $lstLieu;
            $lstLieu->setVille($this);
        }

        return $this;
    }

    public function removeLstLieu(Lieu $lstLieu): self
    {
        if ($this->lstLieu->removeElement($lstLieu)) {
            // set the owning side to null (unless already changed)
            if ($lstLieu->getVille() === $this) {
                $lstLieu->setVille(null);
            }
        }

        return $this;
    }
}

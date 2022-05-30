<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $rue;

    #[ORM\Column(type: 'float')]
    private $latitude;

    #[ORM\Column(type: 'float')]
    private $longitude;

    #[ORM\OneToMany(mappedBy: 'lieu', targetEntity: Sortie::class)]
    private $lstSortie;

    public function __construct()
    {
        $this->lstSortie = new ArrayCollection();
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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
            $lstSortie->setLieu($this);
        }

        return $this;
    }

    public function removeLstSortie(Sortie $lstSortie): self
    {
        if ($this->lstSortie->removeElement($lstSortie)) {
            // set the owning side to null (unless already changed)
            if ($lstSortie->getLieu() === $this) {
                $lstSortie->setLieu(null);
            }
        }

        return $this;
    }
}

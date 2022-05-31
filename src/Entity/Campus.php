<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Sortie::class, orphanRemoval: true)]
    private $lstSortie;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Participant::class)]
    private $lstParticipant;

    public function __construct()
    {
        $this->lstSortie = new ArrayCollection();
        $this->lstParticipant = new ArrayCollection();
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
            $lstSortie->setCampus($this);
        }

        return $this;
    }

    public function removeLstSortie(Sortie $lstSortie): self
    {
        if ($this->lstSortie->removeElement($lstSortie)) {
            // set the owning side to null (unless already changed)
            if ($lstSortie->getCampus() === $this) {
                $lstSortie->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getLstParticipant(): Collection
    {
        return $this->lstParticipant;
    }

    public function addLstParticipant(Participant $lstParticipant): self
    {
        if (!$this->lstParticipant->contains($lstParticipant)) {
            $this->lstParticipant[] = $lstParticipant;
            $lstParticipant->setCampus($this);
        }

        return $this;
    }

    public function removeLstParticipant(Participant $lstParticipant): self
    {
        if ($this->lstParticipant->removeElement($lstParticipant)) {
            // set the owning side to null (unless already changed)
            if ($lstParticipant->getCampus() === $this) {
                $lstParticipant->setCampus(null);
            }
        }

        return $this;
    }

}

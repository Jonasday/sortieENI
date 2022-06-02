<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'datetime')]
    private $dateHeureDebut;

    #[ORM\Column(type: 'integer')]
    private $duree;

    #[ORM\Column(type: 'datetime')]
    private $dateLimiteInscription;

    #[ORM\Column(type: 'integer')]
    private $nbInscriptionsMax;

    #[ORM\Column(type: 'text')]
    private $infosSortie;


    #[ORM\ManyToOne(targetEntity: Participant::class, inversedBy: 'ldtSortieOrganise')]
    #[ORM\JoinColumn(nullable: false)]
    private $organisateur;

    #[ORM\ManyToMany(targetEntity: Participant::class, mappedBy: 'lstSortie')]
    private $lstParticipant;

    public function __construct()
    {
        $this->lstParticipant = new ArrayCollection();
    }

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;

    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $lieu;

    #[ORM\ManyToOne(targetEntity: Etat::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $etat;

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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }


    public function getLstParticipant()
    {
        return $this->lstParticipant;
    }

    public function addLstParticipant(Participant $lstParticipant): self
    {
        if (!$this->lstParticipant->contains($lstParticipant)) {
            $this->lstParticipant[] = $lstParticipant;
            $lstParticipant->addLstSortie($this);
        }

        return $this;
    }

    public function removeLstParticipant(Participant $lstParticipant): self
    {
        if ($this->lstParticipant->removeElement($lstParticipant)) {
            $lstParticipant->removeLstSortie($this);
        }

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

}

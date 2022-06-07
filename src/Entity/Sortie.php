<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

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

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;

    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $lieu;

    #[ORM\ManyToOne(targetEntity: Etat::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $motif;

    #[ORM\OneToMany(mappedBy: 'sortie', targetEntity: SortieInscription::class)]
    private $lstParticipantInscript;

    public function __construct()
    {
        $this->lstParticipantInscript = new ArrayCollection();
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

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }


    /**
     * Teste si un User est inscrit à cette sortie
     *
     * @param UserInterface $user
     * @return bool
     */
    public function isSubscribed(UserInterface $user): bool
    {
        foreach($this->getLstParticipantInscript() as $participant){
            if ($participant->getParticipant() === $user){
                return true;
            }
        }

        return false;
    }

    /**
     * @return Collection<int, SortieInscription>
     */
    public function getLstParticipantInscript(): Collection
    {
        return $this->lstParticipantInscript;
    }

    public function addLstParticipantInscript(SortieInscription $lstParticipantInscript): self
    {
        if (!$this->lstParticipantInscript->contains($lstParticipantInscript)) {
            $this->lstParticipantInscript[] = $lstParticipantInscript;
            $lstParticipantInscript->setSortie($this);
        }

        return $this;
    }

    public function removeLstParticipantInscript(SortieInscription $lstParticipantInscript): self
    {
        if ($this->lstParticipantInscript->removeElement($lstParticipantInscript)) {
            // set the owning side to null (unless already changed)
            if ($lstParticipantInscript->getSortie() === $this) {
                $lstParticipantInscript->setSortie(null);
            }
        }

        return $this;
    }

}

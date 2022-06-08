<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    /**
     * @Assert\GreaterThan("today", message="La date de début ne peut être antérieure à aujourd'hui !")
     */
    #[ORM\Column(type: 'datetime')]
    private $dateHeureDebut;

    /**
     * @Assert\GreaterThanOrEqual("30", message="La durée de la sortie doit être supérieure à 30 minutes  !")
     */
    #[ORM\Column(type: 'integer')]
    private $duree;

    /**
     * @Assert\LessThanOrEqual(propertyPath="dateHeureDebut", message="La date de clôture des inscriptions doit être avant le début de la sortie !")
     * @Assert\GreaterThan("today", message="La date de clôture des inscriptions ne peut être antérieure à aujourd'hui !")
     */
    #[ORM\Column(type: 'datetime')]
    private $dateLimiteInscription;

    /**
     * @Assert\GreaterThanOrEqual("2", message="Pour créer une sortie il faut au minimun 2 personnes !")
     */
    #[ORM\Column(type: 'integer')]
    private $nbInscriptionsMax;

    /**
     * @Assert\GreaterThanOrEqual("2", message="Pour créer une sortie il faut au minimun 2 personnes !")
     * @Assert\Regex(pattern="/[a-zA-Z0-9 ]+/", match=true, message="Les caractères spéciaux sont interdits dans la description")
     */
    #[ORM\Column(type: 'text')]
    private $infosSortie;


    #[ORM\ManyToOne(targetEntity: Participant::class, inversedBy: 'lstSortieOrganise')]
    #[ORM\JoinColumn(nullable: false)]
    private $organisateur;
    

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;

    #[ORM\ManyToOne(targetEntity: Lieu::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $lieu;

    //ccouou

    #[ORM\ManyToOne(targetEntity: Etat::class, inversedBy: 'lstSortie')]
    #[ORM\JoinColumn(nullable: false)]
    private $etat;

    #[ORM\ManyToMany(targetEntity: Participant::class, inversedBy: 'lstSortie')]
    private $lstParticipant;

    public function __construct()
    {
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

//    /**
//     * Teste si un User est inscrit à cette sortie
//     *
//     * @param UserInterface $user
//     * @return bool
//     */
//    public function isSubscribed(UserInterface $user): bool
//    {
//        foreach($this->getLstParticipant() as $participant){
//            if ($participant->getParticipant() === $user){
//                return true;
//            }
//        }
//
//        return false;
//    }

/**
 * @return Collection<int, Participant>
 */
public function getLstParticipant(): Collection
{
    return $this->lstParticipant;
}

    /**
     * @param ArrayCollection $lstParticipant
     * @return Sortie
     */
    public function setLstParticipant(ArrayCollection $lstParticipant): Sortie
    {
        $this->lstParticipant = $lstParticipant;
        return $this;
    }

public function addLstParticipant(Participant $lstParticipant): self
{
    if (!$this->lstParticipant->contains($lstParticipant)) {
        $this->lstParticipant[] = $lstParticipant;
    }

    return $this;
}

public function removeLstParticipant(Participant $lstParticipant): self
{
    $this->lstParticipant->removeElement($lstParticipant);

    return $this;
}

}

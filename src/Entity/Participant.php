<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 50)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50)]
    private $prenom;

    #[ORM\Column(type: 'boolean')]
    private $actif;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Sortie::class, orphanRemoval: true)]
    private $lstSortieOrganise;

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'lstParticipant')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;

    #[ORM\Column(type: 'string', length: 50)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 50)]
    private $pseudo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'participant', targetEntity: SortieInscription::class)]
    private $lstSortieInscrit;

    public function __construct()
    {
        $this->lstSortieInscrit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

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

    /**
     * @return Collection<int, Sortie>
     */
    public function getLstSortieOrganise(): Collection
    {
        return $this->lstSortieOrganise;
    }

    public function addLdtSortieOrganise(Sortie $lstSortieOrganise): self
    {
        if (!$this->lstSortieOrganise->contains($lstSortieOrganise)) {
            $this->lstSortieOrganise[] = $lstSortieOrganise;
            $lstSortieOrganise->setOrganisateur($this);
        }

        return $this;
    }

    public function removeLstSortieOrganise(Sortie $lstSortieOrganise): self
    {
        if ($this->lstSortieOrganise->removeElement($lstSortieOrganise)) {
            // set the owning side to null (unless already changed)
            if ($lstSortieOrganise->getOrganisateur() === $this) {
                $lstSortieOrganise->setOrganisateur(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLstSortieInscrit(): ?SortieInscription
    {
        return $this->lstSortieInscrit;
    }

    public function setLstSortieInscrit(?SortieInscription $lstSortieInscrit): self
    {
        $this->lstSortieInscrit = $lstSortieInscrit;

        return $this;
    }

    public function addLstSortieInscrit(SortieInscription $lstSortieInscrit): self
    {
        if (!$this->lstSortieInscrit->contains($lstSortieInscrit)) {
            $this->lstSortieInscrit[] = $lstSortieInscrit;
            $lstSortieInscrit->setParticipant($this);
        }

        return $this;
    }

    public function removeLstSortieInscrit(SortieInscription $lstSortieInscrit): self
    {
        if ($this->lstSortieInscrit->removeElement($lstSortieInscrit)) {
            // set the owning side to null (unless already changed)
            if ($lstSortieInscrit->getParticipant() === $this) {
                $lstSortieInscrit->setParticipant(null);
            }
        }

        return $this;
    }

}

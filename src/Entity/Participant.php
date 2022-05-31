<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'integer')]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $mail;

    #[ORM\Column(type: 'string', length: 255)]
    private $motPasse;

    #[ORM\Column(type: 'boolean')]
    private $actif;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Sortie::class, orphanRemoval: true)]
    private $ldtSortieOrganise;

    #[ORM\ManyToMany(targetEntity: Sortie::class, inversedBy: 'lstParticipant')]
    private $lstSortie;

    public function __construct()
    {
        $this->ldtSortieOrganise = new ArrayCollection();
        $this->lstSortie = new ArrayCollection();
    }

    #[ORM\ManyToOne(targetEntity: Campus::class, inversedBy: 'lstParticipant')]
    #[ORM\JoinColumn(nullable: false)]
    private $campus;

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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMotPasse(): ?string
    {
        return $this->motPasse;
    }

    public function setMotPasse(string $motPasse): self
    {
        $this->motPasse = $motPasse;

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
    public function getLdtSortieOrganise(): Collection
    {
        return $this->ldtSortieOrganise;
    }

    public function addLdtSortieOrganise(Sortie $ldtSortieOrganise): self
    {
        if (!$this->ldtSortieOrganise->contains($ldtSortieOrganise)) {
            $this->ldtSortieOrganise[] = $ldtSortieOrganise;
            $ldtSortieOrganise->setOrganisateur($this);
        }

        return $this;
    }

    public function removeLdtSortieOrganise(Sortie $ldtSortieOrganise): self
    {
        if ($this->ldtSortieOrganise->removeElement($ldtSortieOrganise)) {
            // set the owning side to null (unless already changed)
            if ($ldtSortieOrganise->getOrganisateur() === $this) {
                $ldtSortieOrganise->setOrganisateur(null);
            }
        }

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
        }

        return $this;
    }

    public function removeLstSortie(Sortie $lstSortie): self
    {
        $this->lstSortie->removeElement($lstSortie);

        return $this;
    }
}
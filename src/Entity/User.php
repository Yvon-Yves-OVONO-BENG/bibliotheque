<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Membre $membre = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $bloque = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Armoire::class)]
    private Collection $armoires;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Auteur::class)]
    private Collection $enregistreAuteurs;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: Auteur::class)]
    private Collection $modifieAuteurs;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Auteur::class)]
    private Collection $supprimeAuteurs;

    #[ORM\Column(length: 255)]
    private ?string $temoin = null;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Editeur::class)]
    private Collection $enregistreEditeurs;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: Editeur::class)]
    private Collection $modifieEditeurs;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Editeur::class)]
    private Collection $supprimeEditeurs;

    public function __construct()
    {
        $this->armoires = new ArrayCollection();
        $this->enregistreAuteurs = new ArrayCollection();
        $this->modifieAuteurs = new ArrayCollection();
        $this->supprimeAuteurs = new ArrayCollection();
        $this->enregistreEditeurs = new ArrayCollection();
        $this->modifieEditeurs = new ArrayCollection();
        $this->supprimeEditeurs = new ArrayCollection();
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
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
     * @return Collection<int, Armoire>
     */
    public function getArmoires(): Collection
    {
        return $this->armoires;
    }

    public function addArmoire(Armoire $armoire): self
    {
        if (!$this->armoires->contains($armoire)) {
            $this->armoires->add($armoire);
            $armoire->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeArmoire(Armoire $armoire): self
    {
        if ($this->armoires->removeElement($armoire)) {
            // set the owning side to null (unless already changed)
            if ($armoire->getEnregistrePar() === $this) {
                $armoire->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getEnregistreAuteurs(): Collection
    {
        return $this->enregistreAuteurs;
    }

    public function addEnregistreAuteur(Auteur $enregistreAuteur): self
    {
        if (!$this->enregistreAuteurs->contains($enregistreAuteur)) {
            $this->enregistreAuteurs->add($enregistreAuteur);
            $enregistreAuteur->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreAuteur(Auteur $enregistreAuteur): self
    {
        if ($this->enregistreAuteurs->removeElement($enregistreAuteur)) {
            // set the owning side to null (unless already changed)
            if ($enregistreAuteur->getEnregistrePar() === $this) {
                $enregistreAuteur->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getModifieAuteurs(): Collection
    {
        return $this->modifieAuteurs;
    }

    public function addModifieAuteur(Auteur $modifieAuteur): self
    {
        if (!$this->modifieAuteurs->contains($modifieAuteur)) {
            $this->modifieAuteurs->add($modifieAuteur);
            $modifieAuteur->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieAuteur(Auteur $modifieAuteur): self
    {
        if ($this->modifieAuteurs->removeElement($modifieAuteur)) {
            // set the owning side to null (unless already changed)
            if ($modifieAuteur->getModifiePar() === $this) {
                $modifieAuteur->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getSupprimeAuteurs(): Collection
    {
        return $this->supprimeAuteurs;
    }

    public function addSupprimeAuteur(Auteur $supprimeAuteur): self
    {
        if (!$this->supprimeAuteurs->contains($supprimeAuteur)) {
            $this->supprimeAuteurs->add($supprimeAuteur);
            $supprimeAuteur->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeAuteur(Auteur $supprimeAuteur): self
    {
        if ($this->supprimeAuteurs->removeElement($supprimeAuteur)) {
            // set the owning side to null (unless already changed)
            if ($supprimeAuteur->getSupprimePar() === $this) {
                $supprimeAuteur->setSupprimePar(null);
            }
        }

        return $this;
    }

    public function getTemoin(): ?string
    {
        return $this->temoin;
    }

    public function setTemoin(string $temoin): self
    {
        $this->temoin = $temoin;

        return $this;
    }

    /**
     * @return Collection<int, Editeur>
     */
    public function getEnregistreEditeurs(): Collection
    {
        return $this->enregistreEditeurs;
    }

    public function addEnregistreEditeur(Editeur $enregistreEditeur): self
    {
        if (!$this->enregistreEditeurs->contains($enregistreEditeur)) {
            $this->enregistreEditeurs->add($enregistreEditeur);
            $enregistreEditeur->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreEditeur(Editeur $enregistreEditeur): self
    {
        if ($this->enregistreEditeurs->removeElement($enregistreEditeur)) {
            // set the owning side to null (unless already changed)
            if ($enregistreEditeur->getEnregistrePar() === $this) {
                $enregistreEditeur->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Editeur>
     */
    public function getModifieEditeurs(): Collection
    {
        return $this->modifieEditeurs;
    }

    public function addModifieEditeur(Editeur $modifieEditeur): self
    {
        if (!$this->modifieEditeurs->contains($modifieEditeur)) {
            $this->modifieEditeurs->add($modifieEditeur);
            $modifieEditeur->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieEditeur(Editeur $modifieEditeur): self
    {
        if ($this->modifieEditeurs->removeElement($modifieEditeur)) {
            // set the owning side to null (unless already changed)
            if ($modifieEditeur->getModifiePar() === $this) {
                $modifieEditeur->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Editeur>
     */
    public function getSupprimeEditeurs(): Collection
    {
        return $this->supprimeEditeurs;
    }

    public function addSupprimeEditeur(Editeur $supprimeEditeur): self
    {
        if (!$this->supprimeEditeurs->contains($supprimeEditeur)) {
            $this->supprimeEditeurs->add($supprimeEditeur);
            $supprimeEditeur->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeEditeur(Editeur $supprimeEditeur): self
    {
        if ($this->supprimeEditeurs->removeElement($supprimeEditeur)) {
            // set the owning side to null (unless already changed)
            if ($supprimeEditeur->getSupprimePar() === $this) {
                $supprimeEditeur->setSupprimePar(null);
            }
        }

        return $this;
    }

}

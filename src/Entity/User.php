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

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: ModePaiement::class)]
    private Collection $enregistreModePaiements;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: ModePaiement::class)]
    private Collection $modifieModePaiements;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: ModePaiement::class)]
    private Collection $supprimeModePaiements;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Armoire::class)]
    private Collection $enregistreArmoires;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: Armoire::class)]
    private Collection $modifieArmoires;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Armoire::class)]
    private Collection $supprimeArmoires;

    public function __construct()
    {
        $this->enregistreAuteurs = new ArrayCollection();
        $this->modifieAuteurs = new ArrayCollection();
        $this->supprimeAuteurs = new ArrayCollection();
        $this->enregistreEditeurs = new ArrayCollection();
        $this->modifieEditeurs = new ArrayCollection();
        $this->supprimeEditeurs = new ArrayCollection();
        $this->enregistreModePaiements = new ArrayCollection();
        $this->modifieModePaiements = new ArrayCollection();
        $this->supprimeModePaiements = new ArrayCollection();
        $this->enregistreArmoires = new ArrayCollection();
        $this->modifieArmoires = new ArrayCollection();
        $this->supprimeArmoires = new ArrayCollection();
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

    /**
     * @return Collection<int, ModePaiement>
     */
    public function getEnregistreModePaiements(): Collection
    {
        return $this->enregistreModePaiements;
    }

    public function addEnregistreModePaiement(ModePaiement $enregistreModePaiement): self
    {
        if (!$this->enregistreModePaiements->contains($enregistreModePaiement)) {
            $this->enregistreModePaiements->add($enregistreModePaiement);
            $enregistreModePaiement->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreModePaiement(ModePaiement $enregistreModePaiement): self
    {
        if ($this->enregistreModePaiements->removeElement($enregistreModePaiement)) {
            // set the owning side to null (unless already changed)
            if ($enregistreModePaiement->getEnregistrePar() === $this) {
                $enregistreModePaiement->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ModePaiement>
     */
    public function getModifieModePaiements(): Collection
    {
        return $this->modifieModePaiements;
    }

    public function addModifieModePaiement(ModePaiement $modifieModePaiement): self
    {
        if (!$this->modifieModePaiements->contains($modifieModePaiement)) {
            $this->modifieModePaiements->add($modifieModePaiement);
            $modifieModePaiement->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieModePaiement(ModePaiement $modifieModePaiement): self
    {
        if ($this->modifieModePaiements->removeElement($modifieModePaiement)) {
            // set the owning side to null (unless already changed)
            if ($modifieModePaiement->getModifiePar() === $this) {
                $modifieModePaiement->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ModePaiement>
     */
    public function getSupprimeModePaiements(): Collection
    {
        return $this->supprimeModePaiements;
    }

    public function addSupprimeModePaiement(ModePaiement $supprimeModePaiement): self
    {
        if (!$this->supprimeModePaiements->contains($supprimeModePaiement)) {
            $this->supprimeModePaiements->add($supprimeModePaiement);
            $supprimeModePaiement->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeModePaiement(ModePaiement $supprimeModePaiement): self
    {
        if ($this->supprimeModePaiements->removeElement($supprimeModePaiement)) {
            // set the owning side to null (unless already changed)
            if ($supprimeModePaiement->getSupprimePar() === $this) {
                $supprimeModePaiement->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Armoire>
     */
    public function getEnregistreArmoires(): Collection
    {
        return $this->enregistreArmoires;
    }

    public function addEnregistreArmoire(Armoire $enregistreArmoire): self
    {
        if (!$this->enregistreArmoires->contains($enregistreArmoire)) {
            $this->enregistreArmoires->add($enregistreArmoire);
            $enregistreArmoire->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreArmoire(Armoire $enregistreArmoire): self
    {
        if ($this->enregistreArmoires->removeElement($enregistreArmoire)) {
            // set the owning side to null (unless already changed)
            if ($enregistreArmoire->getEnregistrePar() === $this) {
                $enregistreArmoire->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Armoire>
     */
    public function getModifieArmoires(): Collection
    {
        return $this->modifieArmoires;
    }

    public function addModifieArmoire(Armoire $modifieArmoire): self
    {
        if (!$this->modifieArmoires->contains($modifieArmoire)) {
            $this->modifieArmoires->add($modifieArmoire);
            $modifieArmoire->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieArmoire(Armoire $modifieArmoire): self
    {
        if ($this->modifieArmoires->removeElement($modifieArmoire)) {
            // set the owning side to null (unless already changed)
            if ($modifieArmoire->getModifiePar() === $this) {
                $modifieArmoire->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Armoire>
     */
    public function getSupprimeArmoires(): Collection
    {
        return $this->supprimeArmoires;
    }

    public function addSupprimeArmoire(Armoire $supprimeArmoire): self
    {
        if (!$this->supprimeArmoires->contains($supprimeArmoire)) {
            $this->supprimeArmoires->add($supprimeArmoire);
            $supprimeArmoire->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeArmoire(Armoire $supprimeArmoire): self
    {
        if ($this->supprimeArmoires->removeElement($supprimeArmoire)) {
            // set the owning side to null (unless already changed)
            if ($supprimeArmoire->getSupprimePar() === $this) {
                $supprimeArmoire->setSupprimePar(null);
            }
        }

        return $this;
    }

}

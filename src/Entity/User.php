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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Auteur::class)]
    private Collection $enregistreAuteurs;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: Auteur::class)]
    private Collection $modifieAuteurs;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Auteur::class)]
    private Collection $supprimeAuteurs;

    #[ORM\Column(length: 255)]
    private ?string $temoin = null;


    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Livre::class)]
    private Collection $livres;

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

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: Fournisseur::class)]
    private Collection $enregistreFournisseurs;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: Fournisseur::class)]
    private Collection $modifieFournisseurs;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Fournisseur::class)]
    private Collection $supprimeFournisseurs;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: GenreLitteraire::class)]
    private Collection $enregistreGenreLitteraires;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: GenreLitteraire::class)]
    private Collection $modifieGenreLitteraires;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: GenreLitteraire::class)]
    private Collection $supprimeGenreLitteraires;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: StatutEmprunt::class)]
    private Collection $enregistreStatutEmprunts;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: StatutEmprunt::class)]
    private Collection $modifieStatutEmprunts;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: StatutEmprunt::class)]
    private Collection $supprimeStatutEmprunts;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: EtatExemplaire::class)]
    private Collection $enregistreEtatExemplaires;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: EtatExemplaire::class)]
    private Collection $modifieEtatExempalires;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: EtatExemplaire::class)]
    private Collection $supprimeEtatExemplaires;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: StatutLivre::class)]
    private Collection $enregistreStatutLivres;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: StatutLivre::class)]
    private Collection $modifieStatutLivres;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: StatutLivre::class)]
    private Collection $supprimeStatutLivres;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: EtatPaiement::class)]
    private Collection $enregistreEtatPaiements;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: EtatPaiement::class)]
    private Collection $modifieEtatPaiements;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: EtatPaiement::class)]
    private Collection $supprimeEtatPaiements;

    #[ORM\OneToMany(mappedBy: 'enregistrePar', targetEntity: EtatReservation::class)]
    private Collection $enregistreEtatReservations;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: EtatReservation::class)]
    private Collection $modifieEtatReservations;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: EtatReservation::class)]
    private Collection $supprimeEtatReservations;

    #[ORM\OneToMany(mappedBy: 'modifiePar', targetEntity: Livre::class)]
    private Collection $modifieLivres;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Livre::class)]
    private Collection $supprimeLivres;

    #[ORM\OneToMany(mappedBy: 'supprimePar', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Membre::class)]
    private Collection $membres;


    public function __construct()
    {
        $this->enregistreAuteurs = new ArrayCollection();
        $this->modifieAuteurs = new ArrayCollection();
        $this->supprimeAuteurs = new ArrayCollection();

        $this->livres = new ArrayCollection();

        $this->enregistreEditeurs = new ArrayCollection();
        $this->modifieEditeurs = new ArrayCollection();
        $this->supprimeEditeurs = new ArrayCollection();
        $this->enregistreModePaiements = new ArrayCollection();
        $this->modifieModePaiements = new ArrayCollection();
        $this->supprimeModePaiements = new ArrayCollection();
        $this->enregistreArmoires = new ArrayCollection();
        $this->modifieArmoires = new ArrayCollection();
        $this->supprimeArmoires = new ArrayCollection();
        $this->enregistreFournisseurs = new ArrayCollection();
        $this->modifieFournisseurs = new ArrayCollection();
        $this->supprimeFournisseurs = new ArrayCollection();
        $this->enregistreGenreLitteraires = new ArrayCollection();
        $this->modifieGenreLitteraires = new ArrayCollection();
        $this->supprimeGenreLitteraires = new ArrayCollection();
        $this->enregistreStatutEmprunts = new ArrayCollection();
        $this->modifieStatutEmprunts = new ArrayCollection();
        $this->supprimeStatutEmprunts = new ArrayCollection();
        $this->enregistreEtatExemplaires = new ArrayCollection();
        $this->modifieEtatExempalires = new ArrayCollection();
        $this->supprimeEtatExemplaires = new ArrayCollection();
        $this->enregistreStatutLivres = new ArrayCollection();
        $this->modifieStatutLivres = new ArrayCollection();
        $this->supprimeStatutLivres = new ArrayCollection();
        $this->enregistreEtatPaiements = new ArrayCollection();
        $this->modifieEtatPaiements = new ArrayCollection();
        $this->supprimeEtatPaiements = new ArrayCollection();
        $this->enregistreEtatReservations = new ArrayCollection();
        $this->modifieEtatReservations = new ArrayCollection();
        $this->supprimeEtatReservations = new ArrayCollection();
        $this->modifieLivres = new ArrayCollection();
        $this->supprimeLivres = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
        $this->membres = new ArrayCollection();

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

     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setEnregistrePar($this);
        }

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


    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getEnregistrePar() === $this) {
                $livre->setEnregistrePar(null);
            }

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

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getEnregistreFournisseurs(): Collection
    {
        return $this->enregistreFournisseurs;
    }

    public function addEnregistreFournisseur(Fournisseur $enregistreFournisseur): self
    {
        if (!$this->enregistreFournisseurs->contains($enregistreFournisseur)) {
            $this->enregistreFournisseurs->add($enregistreFournisseur);
            $enregistreFournisseur->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreFournisseur(Fournisseur $enregistreFournisseur): self
    {
        if ($this->enregistreFournisseurs->removeElement($enregistreFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($enregistreFournisseur->getEnregistrePar() === $this) {
                $enregistreFournisseur->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getModifieFournisseurs(): Collection
    {
        return $this->modifieFournisseurs;
    }

    public function addModifieFournisseur(Fournisseur $modifieFournisseur): self
    {
        if (!$this->modifieFournisseurs->contains($modifieFournisseur)) {
            $this->modifieFournisseurs->add($modifieFournisseur);
            $modifieFournisseur->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieFournisseur(Fournisseur $modifieFournisseur): self
    {
        if ($this->modifieFournisseurs->removeElement($modifieFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($modifieFournisseur->getModifiePar() === $this) {
                $modifieFournisseur->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getSupprimeFournisseurs(): Collection
    {
        return $this->supprimeFournisseurs;
    }

    public function addSupprimeFournisseur(Fournisseur $supprimeFournisseur): self
    {
        if (!$this->supprimeFournisseurs->contains($supprimeFournisseur)) {
            $this->supprimeFournisseurs->add($supprimeFournisseur);
            $supprimeFournisseur->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeFournisseur(Fournisseur $supprimeFournisseur): self
    {
        if ($this->supprimeFournisseurs->removeElement($supprimeFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($supprimeFournisseur->getSupprimePar() === $this) {
                $supprimeFournisseur->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GenreLitteraire>
     */
    public function getEnregistreGenreLitteraires(): Collection
    {
        return $this->enregistreGenreLitteraires;
    }

    public function addEnregistreGenreLitteraire(GenreLitteraire $enregistreGenreLitteraire): self
    {
        if (!$this->enregistreGenreLitteraires->contains($enregistreGenreLitteraire)) {
            $this->enregistreGenreLitteraires->add($enregistreGenreLitteraire);
            $enregistreGenreLitteraire->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreGenreLitteraire(GenreLitteraire $enregistreGenreLitteraire): self
    {
        if ($this->enregistreGenreLitteraires->removeElement($enregistreGenreLitteraire)) {
            // set the owning side to null (unless already changed)
            if ($enregistreGenreLitteraire->getEnregistrePar() === $this) {
                $enregistreGenreLitteraire->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GenreLitteraire>
     */
    public function getModifieGenreLitteraires(): Collection
    {
        return $this->modifieGenreLitteraires;
    }

    public function addModifieGenreLitteraire(GenreLitteraire $modifieGenreLitteraire): self
    {
        if (!$this->modifieGenreLitteraires->contains($modifieGenreLitteraire)) {
            $this->modifieGenreLitteraires->add($modifieGenreLitteraire);
            $modifieGenreLitteraire->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieGenreLitteraire(GenreLitteraire $modifieGenreLitteraire): self
    {
        if ($this->modifieGenreLitteraires->removeElement($modifieGenreLitteraire)) {
            // set the owning side to null (unless already changed)
            if ($modifieGenreLitteraire->getModifiePar() === $this) {
                $modifieGenreLitteraire->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GenreLitteraire>
     */
    public function getSupprimeGenreLitteraires(): Collection
    {
        return $this->supprimeGenreLitteraires;
    }

    public function addSupprimeGenreLitteraire(GenreLitteraire $supprimeGenreLitteraire): self
    {
        if (!$this->supprimeGenreLitteraires->contains($supprimeGenreLitteraire)) {
            $this->supprimeGenreLitteraires->add($supprimeGenreLitteraire);
            $supprimeGenreLitteraire->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeGenreLitteraire(GenreLitteraire $supprimeGenreLitteraire): self
    {
        if ($this->supprimeGenreLitteraires->removeElement($supprimeGenreLitteraire)) {
            // set the owning side to null (unless already changed)
            if ($supprimeGenreLitteraire->getSupprimePar() === $this) {
                $supprimeGenreLitteraire->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutEmprunt>
     */
    public function getEnregistreStatutEmprunts(): Collection
    {
        return $this->enregistreStatutEmprunts;
    }

    public function addEnregistreStatutEmprunt(StatutEmprunt $enregistreStatutEmprunt): self
    {
        if (!$this->enregistreStatutEmprunts->contains($enregistreStatutEmprunt)) {
            $this->enregistreStatutEmprunts->add($enregistreStatutEmprunt);
            $enregistreStatutEmprunt->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreStatutEmprunt(StatutEmprunt $enregistreStatutEmprunt): self
    {
        if ($this->enregistreStatutEmprunts->removeElement($enregistreStatutEmprunt)) {
            // set the owning side to null (unless already changed)
            if ($enregistreStatutEmprunt->getEnregistrePar() === $this) {
                $enregistreStatutEmprunt->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutEmprunt>
     */
    public function getModifieStatutEmprunts(): Collection
    {
        return $this->modifieStatutEmprunts;
    }

    public function addModifieStatutEmprunt(StatutEmprunt $modifieStatutEmprunt): self
    {
        if (!$this->modifieStatutEmprunts->contains($modifieStatutEmprunt)) {
            $this->modifieStatutEmprunts->add($modifieStatutEmprunt);
            $modifieStatutEmprunt->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieStatutEmprunt(StatutEmprunt $modifieStatutEmprunt): self
    {
        if ($this->modifieStatutEmprunts->removeElement($modifieStatutEmprunt)) {
            // set the owning side to null (unless already changed)
            if ($modifieStatutEmprunt->getModifiePar() === $this) {
                $modifieStatutEmprunt->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutEmprunt>
     */
    public function getSupprimeStatutEmprunts(): Collection
    {
        return $this->supprimeStatutEmprunts;
    }

    public function addSupprimeStatutEmprunt(StatutEmprunt $supprimeStatutEmprunt): self
    {
        if (!$this->supprimeStatutEmprunts->contains($supprimeStatutEmprunt)) {
            $this->supprimeStatutEmprunts->add($supprimeStatutEmprunt);
            $supprimeStatutEmprunt->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeStatutEmprunt(StatutEmprunt $supprimeStatutEmprunt): self
    {
        if ($this->supprimeStatutEmprunts->removeElement($supprimeStatutEmprunt)) {
            // set the owning side to null (unless already changed)
            if ($supprimeStatutEmprunt->getSupprimePar() === $this) {
                $supprimeStatutEmprunt->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatExemplaire>
     */
    public function getEnregistreEtatExemplaires(): Collection
    {
        return $this->enregistreEtatExemplaires;
    }

    public function addEnregistreEtatExemplaire(EtatExemplaire $enregistreEtatExemplaire): self
    {
        if (!$this->enregistreEtatExemplaires->contains($enregistreEtatExemplaire)) {
            $this->enregistreEtatExemplaires->add($enregistreEtatExemplaire);
            $enregistreEtatExemplaire->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreEtatExemplaire(EtatExemplaire $enregistreEtatExemplaire): self
    {
        if ($this->enregistreEtatExemplaires->removeElement($enregistreEtatExemplaire)) {
            // set the owning side to null (unless already changed)
            if ($enregistreEtatExemplaire->getEnregistrePar() === $this) {
                $enregistreEtatExemplaire->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatExemplaire>
     */
    public function getModifieEtatExempalires(): Collection
    {
        return $this->modifieEtatExempalires;
    }

    public function addModifieEtatExempalire(EtatExemplaire $modifieEtatExempalire): self
    {
        if (!$this->modifieEtatExempalires->contains($modifieEtatExempalire)) {
            $this->modifieEtatExempalires->add($modifieEtatExempalire);
            $modifieEtatExempalire->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieEtatExempalire(EtatExemplaire $modifieEtatExempalire): self
    {
        if ($this->modifieEtatExempalires->removeElement($modifieEtatExempalire)) {
            // set the owning side to null (unless already changed)
            if ($modifieEtatExempalire->getModifiePar() === $this) {
                $modifieEtatExempalire->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatExemplaire>
     */
    public function getSupprimeEtatExemplaires(): Collection
    {
        return $this->supprimeEtatExemplaires;
    }

    public function addSupprimeEtatExemplaire(EtatExemplaire $supprimeEtatExemplaire): self
    {
        if (!$this->supprimeEtatExemplaires->contains($supprimeEtatExemplaire)) {
            $this->supprimeEtatExemplaires->add($supprimeEtatExemplaire);
            $supprimeEtatExemplaire->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeEtatExemplaire(EtatExemplaire $supprimeEtatExemplaire): self
    {
        if ($this->supprimeEtatExemplaires->removeElement($supprimeEtatExemplaire)) {
            // set the owning side to null (unless already changed)
            if ($supprimeEtatExemplaire->getSupprimePar() === $this) {
                $supprimeEtatExemplaire->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutLivre>
     */
    public function getEnregistreStatutLivres(): Collection
    {
        return $this->enregistreStatutLivres;
    }

    public function addEnregistreStatutLivre(StatutLivre $enregistreStatutLivre): self
    {
        if (!$this->enregistreStatutLivres->contains($enregistreStatutLivre)) {
            $this->enregistreStatutLivres->add($enregistreStatutLivre);
            $enregistreStatutLivre->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreStatutLivre(StatutLivre $enregistreStatutLivre): self
    {
        if ($this->enregistreStatutLivres->removeElement($enregistreStatutLivre)) {
            // set the owning side to null (unless already changed)
            if ($enregistreStatutLivre->getEnregistrePar() === $this) {
                $enregistreStatutLivre->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutLivre>
     */
    public function getModifieStatutLivres(): Collection
    {
        return $this->modifieStatutLivres;
    }

    public function addModifieStatutLivre(StatutLivre $modifieStatutLivre): self
    {
        if (!$this->modifieStatutLivres->contains($modifieStatutLivre)) {
            $this->modifieStatutLivres->add($modifieStatutLivre);
            $modifieStatutLivre->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieStatutLivre(StatutLivre $modifieStatutLivre): self
    {
        if ($this->modifieStatutLivres->removeElement($modifieStatutLivre)) {
            // set the owning side to null (unless already changed)
            if ($modifieStatutLivre->getModifiePar() === $this) {
                $modifieStatutLivre->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StatutLivre>
     */
    public function getSupprimeStatutLivres(): Collection
    {
        return $this->supprimeStatutLivres;
    }

    public function addSupprimeStatutLivre(StatutLivre $supprimeStatutLivre): self
    {
        if (!$this->supprimeStatutLivres->contains($supprimeStatutLivre)) {
            $this->supprimeStatutLivres->add($supprimeStatutLivre);
            $supprimeStatutLivre->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeStatutLivre(StatutLivre $supprimeStatutLivre): self
    {
        if ($this->supprimeStatutLivres->removeElement($supprimeStatutLivre)) {
            // set the owning side to null (unless already changed)
            if ($supprimeStatutLivre->getSupprimePar() === $this) {
                $supprimeStatutLivre->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatPaiement>
     */
    public function getEnregistreEtatPaiements(): Collection
    {
        return $this->enregistreEtatPaiements;
    }

    public function addEnregistreEtatPaiement(EtatPaiement $enregistreEtatPaiement): self
    {
        if (!$this->enregistreEtatPaiements->contains($enregistreEtatPaiement)) {
            $this->enregistreEtatPaiements->add($enregistreEtatPaiement);
            $enregistreEtatPaiement->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreEtatPaiement(EtatPaiement $enregistreEtatPaiement): self
    {
        if ($this->enregistreEtatPaiements->removeElement($enregistreEtatPaiement)) {
            // set the owning side to null (unless already changed)
            if ($enregistreEtatPaiement->getEnregistrePar() === $this) {
                $enregistreEtatPaiement->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatPaiement>
     */
    public function getModifieEtatPaiements(): Collection
    {
        return $this->modifieEtatPaiements;
    }

    public function addModifieEtatPaiement(EtatPaiement $modifieEtatPaiement): self
    {
        if (!$this->modifieEtatPaiements->contains($modifieEtatPaiement)) {
            $this->modifieEtatPaiements->add($modifieEtatPaiement);
            $modifieEtatPaiement->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieEtatPaiement(EtatPaiement $modifieEtatPaiement): self
    {
        if ($this->modifieEtatPaiements->removeElement($modifieEtatPaiement)) {
            // set the owning side to null (unless already changed)
            if ($modifieEtatPaiement->getModifiePar() === $this) {
                $modifieEtatPaiement->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatPaiement>
     */
    public function getSupprimeEtatPaiements(): Collection
    {
        return $this->supprimeEtatPaiements;
    }

    public function addSupprimeEtatPaiement(EtatPaiement $supprimeEtatPaiement): self
    {
        if (!$this->supprimeEtatPaiements->contains($supprimeEtatPaiement)) {
            $this->supprimeEtatPaiements->add($supprimeEtatPaiement);
            $supprimeEtatPaiement->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeEtatPaiement(EtatPaiement $supprimeEtatPaiement): self
    {
        if ($this->supprimeEtatPaiements->removeElement($supprimeEtatPaiement)) {
            // set the owning side to null (unless already changed)
            if ($supprimeEtatPaiement->getSupprimePar() === $this) {
                $supprimeEtatPaiement->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatReservation>
     */
    public function getEnregistreEtatReservations(): Collection
    {
        return $this->enregistreEtatReservations;
    }

    public function addEnregistreEtatReservation(EtatReservation $enregistreEtatReservation): self
    {
        if (!$this->enregistreEtatReservations->contains($enregistreEtatReservation)) {
            $this->enregistreEtatReservations->add($enregistreEtatReservation);
            $enregistreEtatReservation->setEnregistrePar($this);
        }

        return $this;
    }

    public function removeEnregistreEtatReservation(EtatReservation $enregistreEtatReservation): self
    {
        if ($this->enregistreEtatReservations->removeElement($enregistreEtatReservation)) {
            // set the owning side to null (unless already changed)
            if ($enregistreEtatReservation->getEnregistrePar() === $this) {
                $enregistreEtatReservation->setEnregistrePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatReservation>
     */
    public function getModifieEtatReservations(): Collection
    {
        return $this->modifieEtatReservations;
    }

    public function addModifieEtatReservation(EtatReservation $modifieEtatReservation): self
    {
        if (!$this->modifieEtatReservations->contains($modifieEtatReservation)) {
            $this->modifieEtatReservations->add($modifieEtatReservation);
            $modifieEtatReservation->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieEtatReservation(EtatReservation $modifieEtatReservation): self
    {
        if ($this->modifieEtatReservations->removeElement($modifieEtatReservation)) {
            // set the owning side to null (unless already changed)
            if ($modifieEtatReservation->getModifiePar() === $this) {
                $modifieEtatReservation->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatReservation>
     */
    public function getSupprimeEtatReservations(): Collection
    {
        return $this->supprimeEtatReservations;
    }

    public function addSupprimeEtatReservation(EtatReservation $supprimeEtatReservation): self
    {
        if (!$this->supprimeEtatReservations->contains($supprimeEtatReservation)) {
            $this->supprimeEtatReservations->add($supprimeEtatReservation);
            $supprimeEtatReservation->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeEtatReservation(EtatReservation $supprimeEtatReservation): self
    {
        if ($this->supprimeEtatReservations->removeElement($supprimeEtatReservation)) {
            // set the owning side to null (unless already changed)
            if ($supprimeEtatReservation->getSupprimePar() === $this) {
                $supprimeEtatReservation->setSupprimePar(null);

            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getModifieLivres(): Collection
    {
        return $this->modifieLivres;
    }

    public function addModifieLivre(Livre $modifieLivre): static
    {
        if (!$this->modifieLivres->contains($modifieLivre)) {
            $this->modifieLivres->add($modifieLivre);
            $modifieLivre->setModifiePar($this);
        }

        return $this;
    }

    public function removeModifieLivre(Livre $modifieLivre): static
    {
        if ($this->modifieLivres->removeElement($modifieLivre)) {
            // set the owning side to null (unless already changed)
            if ($modifieLivre->getModifiePar() === $this) {
                $modifieLivre->setModifiePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getSupprimeLivres(): Collection
    {
        return $this->supprimeLivres;
    }

    public function addSupprimeLivre(Livre $supprimeLivre): static
    {
        if (!$this->supprimeLivres->contains($supprimeLivre)) {
            $this->supprimeLivres->add($supprimeLivre);
            $supprimeLivre->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimeLivre(Livre $supprimeLivre): static
    {
        if ($this->supprimeLivres->removeElement($supprimeLivre)) {
            // set the owning side to null (unless already changed)
            if ($supprimeLivre->getSupprimePar() === $this) {
                $supprimeLivre->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }

    public function addExemplaire(Exemplaire $exemplaire): static
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->add($exemplaire);
            $exemplaire->setSupprimePar($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): static
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getSupprimePar() === $this) {
                $exemplaire->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setUser($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getUser() === $this) {
                $membre->setUser(null);
            }
        }

        return $this;
    }

}

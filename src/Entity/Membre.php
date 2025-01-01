<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: EtatExemplaire::class)]
    private Collection $etatExemplaires;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Penalite::class)]
    private Collection $penalites;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: CommentaireLivre::class)]
    private Collection $commentaireLivres;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: NoteEtoileLivre::class)]
    private Collection $noteEtoileLivres;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?User $user = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->etatExemplaires = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->penalites = new ArrayCollection();
        $this->commentaireLivres = new ArrayCollection();
        $this->noteEtoileLivres = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setMembre($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMembre() === $this) {
                $user->setMembre(null);
            }
        }

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

    /**
     * @return Collection<int, EtatExemplaire>
     */
    public function getEtatExemplaires(): Collection
    {
        return $this->etatExemplaires;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }

    public function addExemplaire(Exemplaire $exemplaire): self
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->add($exemplaire);
            $exemplaire->setMembre($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getMembre() === $this) {
                $exemplaire->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setMembre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getMembre() === $this) {
                $emprunt->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setMembre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getMembre() === $this) {
                $reservation->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Penalite>
     */
    public function getPenalites(): Collection
    {
        return $this->penalites;
    }

    public function addPenalite(Penalite $penalite): self
    {
        if (!$this->penalites->contains($penalite)) {
            $this->penalites->add($penalite);
            $penalite->setMembre($this);
        }

        return $this;
    }

    public function removePenalite(Penalite $penalite): self
    {
        if ($this->penalites->removeElement($penalite)) {
            // set the owning side to null (unless already changed)
            if ($penalite->getMembre() === $this) {
                $penalite->setMembre(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, CommentaireLivre>
     */
    public function getCommentaireLivres(): Collection
    {
        return $this->commentaireLivres;
    }

    public function addCommentaireLivre(CommentaireLivre $commentaireLivre): self
    {
        if (!$this->commentaireLivres->contains($commentaireLivre)) {
            $this->commentaireLivres->add($commentaireLivre);
            $commentaireLivre->setMembre($this);
        }

        return $this;
    }

    public function removeCommentaireLivre(CommentaireLivre $commentaireLivre): self
    {
        if ($this->commentaireLivres->removeElement($commentaireLivre)) {
            // set the owning side to null (unless already changed)
            if ($commentaireLivre->getMembre() === $this) {
                $commentaireLivre->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoteEtoileLivre>
     */
    public function getNoteEtoileLivres(): Collection
    {
        return $this->noteEtoileLivres;
    }

    public function addNoteEtoileLivre(NoteEtoileLivre $noteEtoileLivre): self
    {
        if (!$this->noteEtoileLivres->contains($noteEtoileLivre)) {
            $this->noteEtoileLivres->add($noteEtoileLivre);
            $noteEtoileLivre->setMembre($this);
        }

        return $this;
    }

    public function removeNoteEtoileLivre(NoteEtoileLivre $noteEtoileLivre): self
    {
        if ($this->noteEtoileLivres->removeElement($noteEtoileLivre)) {
            // set the owning side to null (unless already changed)
            if ($noteEtoileLivre->getMembre() === $this) {
                $noteEtoileLivre->setMembre(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?GenreLitteraire $genreLitteraire = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Auteur $auteur = null;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePublicationAt = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Editeur $editeur = null;

    #[ORM\Column]
    private ?int $nombreExemplaire = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Langue $langue = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: EtatExemplaire::class)]
    private Collection $etatExemplaires;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?StatutLivre $statutLivre = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Armoire $armoire = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Face $face = null;

    #[ORM\Column]
    private ?int $niveau = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?User $enregistrePar = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $enregistreLeAt = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Photo::class, cascade:['persist'])]
    private Collection $photos;

    #[ORM\Column(nullable: true)]
    private ?bool $supprime = null;

    #[ORM\ManyToOne(inversedBy: 'modifieLivres')]
    private ?User $modifiePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifieLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'supprimeLivres')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\Column]
    private ?int $montantEmprunt = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: LigneEmprunt::class)]
    private Collection $ligneEmprunts;

    public function __construct()
    {
        $this->etatExemplaires = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->ligneEmprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getGenreLitteraire(): ?GenreLitteraire
    {
        return $this->genreLitteraire;
    }

    public function setGenreLitteraire(?GenreLitteraire $genreLitteraire): self
    {
        $this->genreLitteraire = $genreLitteraire;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getDatePublicationAt(): ?\DateTimeInterface
    {
        return $this->datePublicationAt;
    }

    public function setDatePublicationAt(\DateTimeInterface $datePublicationAt): self
    {
        $this->datePublicationAt = $datePublicationAt;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getNombreExemplaire(): ?int
    {
        return $this->nombreExemplaire;
    }

    public function setNombreExemplaire(int $nombreExemplaire): self
    {
        $this->nombreExemplaire = $nombreExemplaire;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

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
            $exemplaire->setLivre($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getLivre() === $this) {
                $exemplaire->setLivre(null);
            }
        }

        return $this;
    }

    public function getStatutLivre(): ?StatutLivre
    {
        return $this->statutLivre;
    }

    public function setStatutLivre(?StatutLivre $statutLivre): self
    {
        $this->statutLivre = $statutLivre;

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
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
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
            $reservation->setLivre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getLivre() === $this) {
                $reservation->setLivre(null);
            }
        }

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getArmoire(): ?Armoire
    {
        return $this->armoire;
    }

    public function setArmoire(?Armoire $armoire): self
    {
        $this->armoire = $armoire;

        return $this;
    }

    public function getFace(): ?Face
    {
        return $this->face;
    }

    public function setFace(?Face $face): self
    {
        $this->face = $face;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getEnregistrePar(): ?User
    {
        return $this->enregistrePar;
    }

    public function setEnregistrePar(?User $enregistrePar): static
    {
        $this->enregistrePar = $enregistrePar;

        return $this;
    }

    public function getEnregistreLeAt(): ?\DateTimeImmutable
    {
        return $this->enregistreLeAt;
    }

    public function setEnregistreLeAt(?\DateTimeImmutable $enregistreLeAt): static
    {
        $this->enregistreLeAt = $enregistreLeAt;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setLivre($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getLivre() === $this) {
                $photo->setLivre(null);
            }
        }

        return $this;
    }

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(?bool $supprime): static
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function getModifiePar(): ?User
    {
        return $this->modifiePar;
    }

    public function setModifiePar(?User $modifiePar): static
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    public function getModifieLeAt(): ?\DateTimeInterface
    {
        return $this->modifieLeAt;
    }

    public function setModifieLeAt(?\DateTimeInterface $modifieLeAt): static
    {
        $this->modifieLeAt = $modifieLeAt;

        return $this;
    }

    public function getSupprimePar(): ?User
    {
        return $this->supprimePar;
    }

    public function setSupprimePar(?User $supprimePar): static
    {
        $this->supprimePar = $supprimePar;

        return $this;
    }

    public function getSupprimeLeAt(): ?\DateTimeInterface
    {
        return $this->supprimeLeAt;
    }

    public function setSupprimeLeAt(?\DateTimeInterface $supprimeLeAt): static
    {
        $this->supprimeLeAt = $supprimeLeAt;

        return $this;
    }

    public function getMontantEmprunt(): ?int
    {
        return $this->montantEmprunt;
    }

    public function setMontantEmprunt(int $montantEmprunt): static
    {
        $this->montantEmprunt = $montantEmprunt;

        return $this;
    }

    /**
     * @return Collection<int, LigneEmprunt>
     */
    public function getLigneEmprunts(): Collection
    {
        return $this->ligneEmprunts;
    }

    public function addLigneEmprunt(LigneEmprunt $ligneEmprunt): static
    {
        if (!$this->ligneEmprunts->contains($ligneEmprunt)) {
            $this->ligneEmprunts->add($ligneEmprunt);
            $ligneEmprunt->setLivre($this);
        }

        return $this;
    }

    public function removeLigneEmprunt(LigneEmprunt $ligneEmprunt): static
    {
        if ($this->ligneEmprunts->removeElement($ligneEmprunt)) {
            // set the owning side to null (unless already changed)
            if ($ligneEmprunt->getLivre() === $this) {
                $ligneEmprunt->setLivre(null);
            }
        }

        return $this;
    }
}

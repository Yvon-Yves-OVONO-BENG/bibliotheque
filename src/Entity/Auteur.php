<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissanceAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $biographie = null;

    #[ORM\ManyToOne(inversedBy: 'auteurs')]
    private ?Nationalite $nationalite = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Livre::class)]
    private Collection $livres;

    #[ORM\ManyToOne(inversedBy: 'auteurs')]
    private ?Sexe $sexe = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\ManyToOne(inversedBy: 'enregistreAuteurs')]
    private ?User $enregistrePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $enregistreLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'modifieAuteurs')]
    private ?User $modifiePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifieLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'supprimeAuteurs')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'auteurs')]
    private ?TypeAuteur $typeAuteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
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

    public function getDateNaissanceAt(): ?\DateTimeInterface
    {
        return $this->dateNaissanceAt;
    }

    public function setDateNaissanceAt(\DateTimeInterface $dateNaissanceAt): self
    {
        $this->dateNaissanceAt = $dateNaissanceAt;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(string $biographie): self
    {
        $this->biographie = $biographie;

        return $this;
    }

    public function getNationalite(): ?Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): self
    {
        $this->nationalite = $nationalite;

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
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setAuteur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getAuteur() === $this) {
                $livre->setAuteur(null);
            }
        }

        return $this;
    }

    public function getSexe(): ?Sexe
    {
        return $this->sexe;
    }

    public function setSexe(?Sexe $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): self
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function getEnregistrePar(): ?User
    {
        return $this->enregistrePar;
    }

    public function setEnregistrePar(?User $enregistrePar): self
    {
        $this->enregistrePar = $enregistrePar;

        return $this;
    }

    public function getEnregistreLeAt(): ?\DateTimeInterface
    {
        return $this->enregistreLeAt;
    }

    public function setEnregistreLeAt(\DateTimeInterface $enregistreLeAt): self
    {
        $this->enregistreLeAt = $enregistreLeAt;

        return $this;
    }

    public function getModifiePar(): ?User
    {
        return $this->modifiePar;
    }

    public function setModifiePar(?User $modifiePar): self
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    public function getModifieLeAt(): ?\DateTimeInterface
    {
        return $this->modifieLeAt;
    }

    public function setModifieLeAt(?\DateTimeInterface $modifieLeAt): self
    {
        $this->modifieLeAt = $modifieLeAt;

        return $this;
    }

    public function getSupprimePar(): ?User
    {
        return $this->supprimePar;
    }

    public function setSupprimePar(?User $supprimePar): self
    {
        $this->supprimePar = $supprimePar;

        return $this;
    }

    public function getSupprimeLeAt(): ?\DateTimeInterface
    {
        return $this->supprimeLeAt;
    }

    public function setSupprimeLeAt(?\DateTimeInterface $supprimeLeAt): self
    {
        $this->supprimeLeAt = $supprimeLeAt;

        return $this;
    }

    public function getTypeAuteur(): ?TypeAuteur
    {
        return $this->typeAuteur;
    }

    public function setTypeAuteur(?TypeAuteur $typeAuteur): self
    {
        $this->typeAuteur = $typeAuteur;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}

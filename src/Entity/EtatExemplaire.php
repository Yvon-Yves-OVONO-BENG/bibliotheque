<?php

namespace App\Entity;

use App\Repository\EtatExemplaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatExemplaireRepository::class)]
class EtatExemplaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etatExemplaire = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'etatExemplaire', targetEntity: Exemplaire::class)]
    private Collection $exemplaires;

    #[ORM\ManyToOne(inversedBy: 'enregistreEtatExemplaires')]
    private ?User $enregistrePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $enregistreLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'modifieEtatExempalires')]
    private ?User $modifiePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifieLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'supprimeEtatExemplaires')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    public function __construct()
    {
        $this->exemplaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatExemplaire(): ?string
    {
        return $this->etatExemplaire;
    }

    public function setEtatExemplaire(string $etatExemplaire): self
    {
        $this->etatExemplaire = $etatExemplaire;

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
            $exemplaire->setEtatExemplaire($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getEtatExemplaire() === $this) {
                $exemplaire->setEtatExemplaire(null);
            }
        }

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

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): self
    {
        $this->supprime = $supprime;

        return $this;
    }
}

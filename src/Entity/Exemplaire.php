<?php

namespace App\Entity;

use App\Repository\ExemplaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExemplaireRepository::class)]
class Exemplaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    private ?EtatExemplaire $etatExemplaire = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    private ?Membre $membre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAcquisitionAt = null;

    #[ORM\Column(length: 255)]
    private ?string $codeExemplaire = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?bool $supprime = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaires')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getEtatExemplaire(): ?EtatExemplaire
    {
        return $this->etatExemplaire;
    }

    public function setEtatExemplaire(?EtatExemplaire $etatExemplaire): self
    {
        $this->etatExemplaire = $etatExemplaire;

        return $this;
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

    public function getDateAcquisitionAt(): ?\DateTimeInterface
    {
        return $this->dateAcquisitionAt;
    }

    public function setDateAcquisitionAt(\DateTimeInterface $dateAcquisitionAt): self
    {
        $this->dateAcquisitionAt = $dateAcquisitionAt;

        return $this;
    }

    public function getCodeExemplaire(): ?string
    {
        return $this->codeExemplaire;
    }

    public function setCodeExemplaire(string $codeExemplaire): self
    {
        $this->codeExemplaire = $codeExemplaire;

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

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(?bool $supprime): static
    {
        $this->supprime = $supprime;

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
}

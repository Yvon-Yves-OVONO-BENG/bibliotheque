<?php

namespace App\Entity;

use App\Repository\LigneEmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneEmpruntRepository::class)]
class LigneEmprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneEmprunts', cascade: ['persist', 'remove'])]
    private ?Emprunt $emprunt = null;

    #[ORM\ManyToOne(inversedBy: 'ligneEmprunts')]
    private ?Livre $livre = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRetourPrevueAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRetourReelleAt = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    private ?int $montant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmprunt(): ?Emprunt
    {
        return $this->emprunt;
    }

    public function setEmprunt(?Emprunt $emprunt): static
    {
        $this->emprunt = $emprunt;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDateRetourPrevueAt(): ?\DateTimeInterface
    {
        return $this->dateRetourPrevueAt;
    }

    public function setDateRetourPrevueAt(\DateTimeInterface $dateRetourPrevueAt): static
    {
        $this->dateRetourPrevueAt = $dateRetourPrevueAt;

        return $this;
    }

    public function getDateRetourReelleAt(): ?\DateTimeInterface
    {
        return $this->dateRetourReelleAt;
    }

    public function setDateRetourReelleAt(\DateTimeInterface $dateRetourReelleAt): static
    {
        $this->dateRetourReelleAt = $dateRetourReelleAt;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }
}

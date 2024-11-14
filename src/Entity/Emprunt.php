<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?Livre $livre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmpruntAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRetourPrevueAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRetourReelleAt = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?StatutEmprunt $statutEmprunt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?ModePaiement $modePaiement = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?EtatPaiement $etatPaiement = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getDateEmpruntAt(): ?\DateTimeInterface
    {
        return $this->dateEmpruntAt;
    }

    public function setDateEmpruntAt(\DateTimeInterface $dateEmpruntAt): self
    {
        $this->dateEmpruntAt = $dateEmpruntAt;

        return $this;
    }

    public function getDateRetourPrevueAt(): ?\DateTimeInterface
    {
        return $this->dateRetourPrevueAt;
    }

    public function setDateRetourPrevueAt(\DateTimeInterface $dateRetourPrevueAt): self
    {
        $this->dateRetourPrevueAt = $dateRetourPrevueAt;

        return $this;
    }

    public function getDateRetourReelleAt(): ?\DateTimeInterface
    {
        return $this->dateRetourReelleAt;
    }

    public function setDateRetourReelleAt(?\DateTimeInterface $dateRetourReelleAt): self
    {
        $this->dateRetourReelleAt = $dateRetourReelleAt;

        return $this;
    }

    public function getStatutEmprunt(): ?StatutEmprunt
    {
        return $this->statutEmprunt;
    }

    public function setStatutEmprunt(?StatutEmprunt $statutEmprunt): self
    {
        $this->statutEmprunt = $statutEmprunt;

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

    public function getModePaiement(): ?ModePaiement
    {
        return $this->modePaiement;
    }

    public function setModePaiement(?ModePaiement $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getEtatPaiement(): ?EtatPaiement
    {
        return $this->etatPaiement;
    }

    public function setEtatPaiement(?EtatPaiement $etatPaiement): self
    {
        $this->etatPaiement = $etatPaiement;

        return $this;
    }
}

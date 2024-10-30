<?php

namespace App\Entity;

use App\Repository\PenaliteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PenaliteRepository::class)]
class Penalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'penalites')]
    private ?Membre $membre = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateApplicationAt = null;

    #[ORM\ManyToOne(inversedBy: 'penalites')]
    private ?StatutPaiement $statutPaiement = null;

    #[ORM\ManyToOne(inversedBy: 'penalites')]
    private ?ModePaiement $modePaiement = null;

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

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateApplicationAt(): ?\DateTimeInterface
    {
        return $this->dateApplicationAt;
    }

    public function setDateApplicationAt(\DateTimeInterface $dateApplicationAt): self
    {
        $this->dateApplicationAt = $dateApplicationAt;

        return $this;
    }

    public function getStatutPaiement(): ?StatutPaiement
    {
        return $this->statutPaiement;
    }

    public function setStatutPaiement(?StatutPaiement $statutPaiement): self
    {
        $this->statutPaiement = $statutPaiement;

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
}

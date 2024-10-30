<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Livre $livre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateReservationAt = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?StatutReservation $statutReservation = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
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

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getDateReservationAt(): ?\DateTimeInterface
    {
        return $this->dateReservationAt;
    }

    public function setDateReservationAt(\DateTimeInterface $dateReservationAt): self
    {
        $this->dateReservationAt = $dateReservationAt;

        return $this;
    }

    public function getStatutReservation(): ?StatutReservation
    {
        return $this->statutReservation;
    }

    public function setStatutReservation(?StatutReservation $statutReservation): self
    {
        $this->statutReservation = $statutReservation;

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
}

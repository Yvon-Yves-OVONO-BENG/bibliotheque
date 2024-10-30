<?php

namespace App\Entity;

use App\Repository\ModePaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModePaiementRepository::class)]
class ModePaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modePaiement = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\OneToMany(mappedBy: 'modePaiement', targetEntity: Penalite::class)]
    private Collection $penalites;

    #[ORM\OneToMany(mappedBy: 'modePaiement', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\OneToMany(mappedBy: 'modePaiement', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->penalites = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

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
            $penalite->setModePaiement($this);
        }

        return $this;
    }

    public function removePenalite(Penalite $penalite): self
    {
        if ($this->penalites->removeElement($penalite)) {
            // set the owning side to null (unless already changed)
            if ($penalite->getModePaiement() === $this) {
                $penalite->setModePaiement(null);
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
            $emprunt->setModePaiement($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getModePaiement() === $this) {
                $emprunt->setModePaiement(null);
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
            $reservation->setModePaiement($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getModePaiement() === $this) {
                $reservation->setModePaiement(null);
            }
        }

        return $this;
    }
}

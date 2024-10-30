<?php

namespace App\Entity;

use App\Repository\StatutPaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutPaiementRepository::class)]
class StatutPaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $statutPaiement = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'statutPaiement', targetEntity: Penalite::class)]
    private Collection $penalites;

    public function __construct()
    {
        $this->penalites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutPaiement(): ?string
    {
        return $this->statutPaiement;
    }

    public function setStatutPaiement(string $statutPaiement): self
    {
        $this->statutPaiement = $statutPaiement;

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
            $penalite->setStatutPaiement($this);
        }

        return $this;
    }

    public function removePenalite(Penalite $penalite): self
    {
        if ($this->penalites->removeElement($penalite)) {
            // set the owning side to null (unless already changed)
            if ($penalite->getStatutPaiement() === $this) {
                $penalite->setStatutPaiement(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\EtatPaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatPaiementRepository::class)]
class EtatPaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etatPaiement = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'etatPaiement', targetEntity: Penalite::class)]
    private Collection $penalites;

    #[ORM\OneToMany(mappedBy: 'etatPaiement', targetEntity: Emprunt::class)]
    private Collection $emprunts;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\ManyToOne(inversedBy: 'enregistreEtatPaiements')]
    private ?User $enregistrePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $enregistreLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'modifieEtatPaiements')]
    private ?User $modifiePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifieLeAt = null;

    #[ORM\ManyToOne(inversedBy: 'supprimeEtatPaiements')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    public function __construct()
    {
        $this->penalites = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatPaiement(): ?string
    {
        return $this->etatPaiement;
    }

    public function setEtatPaiement(string $etatPaiement): self
    {
        $this->etatPaiement = $etatPaiement;

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
            $penalite->setEtatPaiement($this);
        }

        return $this;
    }

    public function removePenalite(Penalite $penalite): self
    {
        if ($this->penalites->removeElement($penalite)) {
            // set the owning side to null (unless already changed)
            if ($penalite->getEtatPaiement() === $this) {
                $penalite->setEtatPaiement(null);
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
            $emprunt->setEtatPaiement($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getEtatPaiement() === $this) {
                $emprunt->setEtatPaiement(null);
            }
        }

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
}

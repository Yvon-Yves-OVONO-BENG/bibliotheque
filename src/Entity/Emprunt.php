<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmpruntAt = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?StatutEmprunt $statutEmprunt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?ModePaiement $modePaiement = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?EtatPaiement $etatPaiement = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    private ?User $enregistrePar = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\ManyToOne]
    private ?User $modifiePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifieLeAt = null;

    #[ORM\ManyToOne]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $qrCode = null;

    #[ORM\OneToMany(mappedBy: 'emprunt', targetEntity: LigneEmprunt::class, cascade: ['persist', 'remove'])]
    private Collection $ligneEmprunts;

    #[ORM\Column]
    private ?int $netAPayer = null;

    public function __construct()
    {
        $this->ligneEmprunts = new ArrayCollection();
    }

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

    public function getDateEmpruntAt(): ?\DateTimeInterface
    {
        return $this->dateEmpruntAt;
    }

    public function setDateEmpruntAt(\DateTimeInterface $dateEmpruntAt): self
    {
        $this->dateEmpruntAt = $dateEmpruntAt;

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

    public function getEnregistrePar(): ?User
    {
        return $this->enregistrePar;
    }

    public function setEnregistrePar(?User $enregistrePar): static
    {
        $this->enregistrePar = $enregistrePar;

        return $this;
    }

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): static
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function getModifiePar(): ?User
    {
        return $this->modifiePar;
    }

    public function setModifiePar(?User $modifiePar): static
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    public function getModifieLeAt(): ?\DateTimeInterface
    {
        return $this->modifieLeAt;
    }

    public function setModifieLeAt(?\DateTimeInterface $modifieLeAt): static
    {
        $this->modifieLeAt = $modifieLeAt;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): static
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    /**
     * @return Collection<int, LigneEmprunt>
     */
    public function getLigneEmprunts(): Collection
    {
        return $this->ligneEmprunts;
    }

    public function addLigneEmprunt(LigneEmprunt $ligneEmprunt): static
    {
        if (!$this->ligneEmprunts->contains($ligneEmprunt)) {
            $this->ligneEmprunts->add($ligneEmprunt);
            $ligneEmprunt->setEmprunt($this);
        }

        return $this;
    }

    public function removeLigneEmprunt(LigneEmprunt $ligneEmprunt): static
    {
        if ($this->ligneEmprunts->removeElement($ligneEmprunt)) {
            // set the owning side to null (unless already changed)
            if ($ligneEmprunt->getEmprunt() === $this) {
                $ligneEmprunt->setEmprunt(null);
            }
        }

        return $this;
    }

    public function getNetAPayer(): ?int
    {
        return $this->netAPayer;
    }

    public function setNetAPayer(int $netAPayer): static
    {
        $this->netAPayer = $netAPayer;

        return $this;
    }
}

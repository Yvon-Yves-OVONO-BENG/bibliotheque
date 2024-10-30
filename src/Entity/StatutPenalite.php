<?php

namespace App\Entity;

use App\Repository\StatutPenaliteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutPenaliteRepository::class)]
class StatutPenalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $statutPenalite = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutPenalite(): ?string
    {
        return $this->statutPenalite;
    }

    public function setStatutPenalite(string $statutPenalite): self
    {
        $this->statutPenalite = $statutPenalite;

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
}

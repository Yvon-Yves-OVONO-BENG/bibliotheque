<?php

namespace App\Entity;

use App\Repository\CommentaireLivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireLivreRepository::class)]
class CommentaireLivre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commentaireLivres')]
    private ?Membre $membre = null;

    #[ORM\Column(length: 255)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommentaireAt = null;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateCommentaireAt(): ?\DateTimeInterface
    {
        return $this->dateCommentaireAt;
    }

    public function setDateCommentaireAt(\DateTimeInterface $dateCommentaireAt): self
    {
        $this->dateCommentaireAt = $dateCommentaireAt;

        return $this;
    }
}

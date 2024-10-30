<?php

namespace App\Entity;

use App\Repository\NoteEtoileLivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteEtoileLivreRepository::class)]
class NoteEtoileLivre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'noteEtoileLivres')]
    private ?Membre $membre = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateNoteAt = null;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDateNoteAt(): ?\DateTimeInterface
    {
        return $this->dateNoteAt;
    }

    public function setDateNoteAt(\DateTimeInterface $dateNoteAt): self
    {
        $this->dateNoteAt = $dateNoteAt;

        return $this;
    }
}

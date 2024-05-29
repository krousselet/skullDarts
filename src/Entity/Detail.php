<?php

namespace App\Entity;

use App\Repository\DetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailRepository::class)]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $activite0 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $activite1 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $activite2 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $heure = null;

    #[ORM\OneToOne(inversedBy: 'detail', cascade: ['persist', 'remove'])]
    private ?Publication $publication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getActivite0(): ?string
    {
        return $this->activite0;
    }

    public function setActivite0(?string $activite0): static
    {
        $this->activite0 = $activite0;

        return $this;
    }

    public function getActivite1(): ?string
    {
        return $this->activite1;
    }

    public function setActivite1(?string $activite1): static
    {
        $this->activite1 = $activite1;

        return $this;
    }

    public function getActivite2(): ?string
    {
        return $this->activite2;
    }

    public function setActivite2(?string $activite2): static
    {
        $this->activite2 = $activite2;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(?string $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): static
    {
        $this->publication = $publication;

        return $this;
    }
}

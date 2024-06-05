<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Sondage $sondage = null;

    #[ORM\Column]
    private string $vote = 'non';

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Utilisateur $user = null;

    #[ORM\Column]
    private ?bool $voted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSondage(): ?Sondage
    {
        return $this->sondage;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }
    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setSondage(?Sondage $sondage): static
    {
        $this->sondage = $sondage;

        return $this;
    }

    public function setVote(string $vote): static
    {
        $this->vote = $vote;

        return $this;
    }


    public function setUser(?Utilisateur $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isVoted(): ?bool
    {
        return $this->voted;
    }

    public function setVoted(bool $voted): static
    {
        $this->voted = $voted;

        return $this;
    }
}

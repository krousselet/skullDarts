<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $creation;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $modification;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphe0 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphe1 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphe2 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphe3 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphe4 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $paragraphe5 = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'publication_id', cascade: ['remove'])]
    private Collection $images;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'publication', cascade: ['remove'])]
    private Collection $commentaires;

    #[ORM\OneToOne(mappedBy: 'publication', cascade: ['persist', 'remove'])]
    private ?Detail $detail = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->creation = new DateTimeImmutable();
        $this->modification = new DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->creation = new \DateTime();
        $this->modification = clone $this->creation;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->modification = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCreation(): ?DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(DateTimeInterface $creation): static
    {
        $this->creation = $creation;

        return $this;
    }

    public function getModification(): ?DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(DateTimeInterface $modification): static
    {
        $this->modification = $modification;

        return $this;
    }

    public function getParagraphe0(): ?string
    {
        return $this->paragraphe0;
    }

    public function setParagraphe0(string $paragraphe0): static
    {
        $this->paragraphe0 = $paragraphe0;

        return $this;
    }

    public function getParagraphe1(): ?string
    {
        return $this->paragraphe1;
    }

    public function setParagraphe1(?string $paragraphe1): void
    {
        $this->paragraphe1 = $paragraphe1;
    }

    public function getParagraphe2(): ?string
    {
        return $this->paragraphe2;
    }

    public function setParagraphe2(?string $paragraphe2): void
    {
        $this->paragraphe2 = $paragraphe2;
    }

    public function getParagraphe3(): ?string
    {
        return $this->paragraphe3;
    }

    public function setParagraphe3(?string $paragraphe3): void
    {
        $this->paragraphe3 = $paragraphe3;
    }

    public function getParagraphe4(): ?string
    {
        return $this->paragraphe4;
    }

    public function setParagraphe4(?string $paragraphe4): void
    {
        $this->paragraphe4 = $paragraphe4;
    }

    public function getParagraphe5(): ?string
    {
        return $this->paragraphe5;
    }

    public function setParagraphe5(?string $paragraphe5): void
    {
        $this->paragraphe5 = $paragraphe5;
    }



    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setPublicationId($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPublicationId() === $this) {
                $image->setPublicationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPublication($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPublication() === $this) {
                $commentaire->setPublication(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->titre;
    }

    public function getDetail(): ?Detail
    {
        return $this->detail;
    }

    public function setDetail(?Detail $detail): static
    {
        // unset the owning side of the relation if necessary
        if ($detail === null && $this->detail !== null) {
            $this->detail->setPublication(null);
        }

        // set the owning side of the relation if necessary
        if ($detail !== null && $detail->getPublication() !== $this) {
            $detail->setPublication($this);
        }

        $this->detail = $detail;

        return $this;
    }

}

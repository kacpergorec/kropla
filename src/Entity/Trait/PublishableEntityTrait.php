<?php

namespace App\Entity\Trait;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

trait PublishableEntityTrait
{

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\ManyToOne]
    private ?User $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }


    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }
}

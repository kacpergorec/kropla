<?php

namespace App\Entity;

use App\Repository\PageRepository;
use App\Entity\Trait\PublishableEntityTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    use PublishableEntityTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $redirectUrl = null;

    #[Gedmo\Slug(fields: ['title'])]
    #[ORM\Column(unique: true)]
    private string $slug;

    #[ORM\ManyToOne(inversedBy: 'pages')]
    private ?Category $category = null;

    #[ORM\Column]
    private ?bool $promoted = false;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $tags = [];


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    public function setRedirectUrl(string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function isPromoted(): ?bool
    {
        return $this->promoted;
    }

    public function setPromoted(bool $promoted): self
    {
        $this->promoted = $promoted;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }
}

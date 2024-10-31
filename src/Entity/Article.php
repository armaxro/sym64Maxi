<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private ?string $Title = null;

    #[ORM\Column(length: 162)]
    private ?string $TitleSlug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeInterface $ArticleDateCreate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $ArticleDatePosted = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ["default" => false])]
    private ?bool $Published = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getTitleSlug(): ?string
    {
        return $this->TitleSlug;
    }

    public function setTitleSlug(string $TitleSlug): static
    {
        $this->TitleSlug = $TitleSlug;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): static
    {
        $this->Text = $Text;

        return $this;
    }

    public function getArticleDateCreate(): ?\DateTimeInterface
    {
        return $this->ArticleDateCreate;
    }

    public function setArticleDateCreate(\DateTimeInterface $ArticleDateCreate): static
    {
        $this->ArticleDateCreate = $ArticleDateCreate;

        return $this;
    }

    public function getArticleDatePosted(): ?\DateTimeInterface
    {
        return $this->ArticleDatePosted;
    }

    public function setArticleDatePosted(?\DateTimeInterface $ArticleDatePosted): static
    {
        $this->ArticleDatePosted = $ArticleDatePosted;
    
        return $this;
    }


    public function getPublished(): ?bool
    {
        return $this->Published;
    }

    public function setPublished(bool $Published): static
    {
        $this->Published = $Published;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->Published;
    }
    
    #[ORM\ManyToMany(targetEntity: Section::class, inversedBy: 'articles')]
    private Collection $sections;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
        }

        return $this;
    }

    public function removeSection(Section $section): static
    {
        $this->sections->removeElement($section);

        return $this;
    }
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
    public function getAuthorUsername(): ?string
    {
        return $this->author ? $this->author->getUsername() : null;
    }
    public function getAuthorFullName(): ?string
    {
        return $this->author ? $this->author->getFullName() : null;
    }
}

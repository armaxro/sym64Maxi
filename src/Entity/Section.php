<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Article;


#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $SectionTitle = null;

    #[ORM\Column(length: 105)]
    private ?string $SectionSlug = null;

    #[ORM\Column(length: 500)]
    private ?string $SectionDetail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectionTitle(): ?string
    {
        return $this->SectionTitle;
    }

    public function setSectionTitle(string $SectionTitle): static
    {
        $this->SectionTitle = $SectionTitle;

        return $this;
    }

    public function getSectionSlug(): ?string
    {
        return $this->SectionSlug;
    }

    public function setSectionSlug(string $SectionSlug): static
    {
        $this->SectionSlug = $SectionSlug;

        return $this;
    }

    public function getSectionDetail(): ?string
    {
        return $this->SectionDetail;
    }

    public function setSectionDetail(string $SectionDetail): static
    {
        $this->SectionDetail = $SectionDetail;

        return $this;
    }
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'sections')]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addSection($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            $article->removeSection($this);
        }

        return $this;
    }
    

}

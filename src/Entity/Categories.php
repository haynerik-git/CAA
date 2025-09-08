<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $display_order = null;

    #[ORM\ManyToMany(targetEntity: Word::class, mappedBy: 'categoriesWord')]
    private Collection $wordCategories;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'parentCategories')]
    private Collection $categoriesParent;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'categoriesParent')]
    private Collection $parentCategories;

    #[ORM\OneToMany(targetEntity: CategoriesTranslation::class, mappedBy: 'categoriesTranslation')]
    private Collection $categoriesTranslations;

    #[ORM\ManyToMany(targetEntity: Sentences::class, mappedBy: 'categoriesSentences')]
    private Collection $sentences;

    #[ORM\ManyToMany(targetEntity: Word::class, mappedBy: 'nextCategories')]
    #[ORM\JoinTable(name:"nextCategorie")]
    private Collection $afterWords;


    public function __construct()
    {
        $this->wordCategories = new ArrayCollection();
        $this->categoriesParent = new ArrayCollection();
        $this->parentCategories = new ArrayCollection();
        $this->categoriesTranslations = new ArrayCollection();
        $this->sentences = new ArrayCollection();
        $this->afterWords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->display_order;
    }

    public function setDisplayOrder(int $display_order): static
    {
        $this->display_order = $display_order;

        return $this;
    }

    /**
     * @return Collection<int, Word>
     */
    public function getWordCategories(): Collection
    {
        return $this->wordCategories;
    }

    public function addWordCategory(Word $wordCategory): static
    {
        if (!$this->wordCategories->contains($wordCategory)) {
            $this->wordCategories->add($wordCategory);
            $wordCategory->addCategoriesWord($this);
        }

        return $this;
    }

    public function removeWordCategory(Word $wordCategory): static
    {
        if ($this->wordCategories->removeElement($wordCategory)) {
            $wordCategory->removeCategoriesWord($this);
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->name;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCategoriesParent(): Collection
    {
        return $this->categoriesParent;
    }

    public function addCategoriesParent(self $categoriesParent): static
    {
        if (!$this->categoriesParent->contains($categoriesParent)) {
            $this->categoriesParent->add($categoriesParent);
        }

        return $this;
    }

    public function removeCategoriesParent(self $categoriesParent): static
    {
        $this->categoriesParent->removeElement($categoriesParent);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentCategories(): Collection
    {
        return $this->parentCategories;
    }

    public function addParentCategory(self $parentCategory): static
    {
        if (!$this->parentCategories->contains($parentCategory)) {
            $this->parentCategories->add($parentCategory);
            $parentCategory->addCategoriesParent($this);
        }

        return $this;
    }

    public function removeParentCategory(self $parentCategory): static
    {
        if ($this->parentCategories->removeElement($parentCategory)) {
            $parentCategory->removeCategoriesParent($this);
        }

        return $this;
    }

    public function getCategoriesTranslationsByLang(string $lang): string
    {
        $langId = (int)$lang;
        $res = $this->getCategoriesTranslations()->filter(function(CategoriesTranslation $wordsTranslations) use ($langId) {
            return $wordsTranslations->getLang()->getId() == $langId;
        });
        foreach ($res as $wordTranslation) {
            return $wordTranslation->getName();
        }
        return $this->name;
    }

    /**
     * @return Collection<int, CategoriesTranslation>
     */
    public function getCategoriesTranslations(): Collection
    {
        return $this->categoriesTranslations;
    }

    public function addCategoriesTranslation(CategoriesTranslation $categoriesTranslation): static
    {
        if (!$this->categoriesTranslations->contains($categoriesTranslation)) {
            $this->categoriesTranslations->add($categoriesTranslation);
            $categoriesTranslation->setCategoriesTranslation($this);
        }

        return $this;
    }

    public function removeCategoriesTranslation(CategoriesTranslation $categoriesTranslation): static
    {
        if ($this->categoriesTranslations->removeElement($categoriesTranslation)) {
            // set the owning side to null (unless already changed)
            if ($categoriesTranslation->getCategoriesTranslation() === $this) {
                $categoriesTranslation->setCategoriesTranslation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sentences>
     */
    public function getSentences(): Collection
    {
        return $this->sentences;
    }

    public function addSentence(Sentences $sentence): static
    {
        if (!$this->sentences->contains($sentence)) {
            $this->sentences->add($sentence);
            $sentence->addCategoriesSentence($this);
        }

        return $this;
    }

    public function removeSentence(Sentences $sentence): static
    {
        if ($this->sentences->removeElement($sentence)) {
            $sentence->removeCategoriesSentence($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Word>
     */
    public function getAfterWords(): Collection
    {
        return $this->afterWords;
    }

    public function addAfterWord(Word $afterWord): static
    {
        if (!$this->afterWords->contains($afterWord)) {
            $this->afterWords->add($afterWord);
            $afterWord->addNextCategory($this);
        }

        return $this;
    }

    public function removeAfterWord(Word $afterWord): static
    {
        if ($this->afterWords->removeElement($afterWord)) {
            $afterWord->removeNextCategory($this);
        }

        return $this;
    }
}

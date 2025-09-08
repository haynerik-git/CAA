<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordRepository::class)]
class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $filename = null;

    #[ORM\Column]
    private ?int $display_order = null;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'wordCategories')]
    private Collection $categoriesWord;

    #[ORM\OneToMany(targetEntity: WordTranslation::class, mappedBy: 'wordTranslation')]
    private Collection $wordTranslations;

    #[ORM\ManyToMany(targetEntity: Sentences::class, mappedBy: 'sentencesWord')]
    private Collection $sentences;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'afterWords')]
    #[ORM\JoinTable(name:"nextCategorie")]
    private Collection $nextCategories;

    #[ORM\OneToMany(targetEntity: UserCategorieWords::class, mappedBy: 'word')]
    private Collection $userCategorieWords;

    #[ORM\OneToMany(targetEntity: PageOrder::class, mappedBy: 'word')]
    private Collection $pageOrders;

    #[ORM\ManyToOne(inversedBy: 'words')]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: UserCategoriesOrder::class, mappedBy: 'word')]
    private Collection $userCategoriesOrders;

    #[ORM\Column(nullable: true)]
    private ?int $arasaac = null;

    #[ORM\ManyToOne(inversedBy: 'words')]
    private ?WordConfiguration $type = null;


    public function __construct()
    {
        $this->categoriesWord = new ArrayCollection();
        $this->lang = new ArrayCollection();
        $this->wordTranslations = new ArrayCollection();
        $this->sentences = new ArrayCollection();
        $this->nextCategories = new ArrayCollection();
        $this->userCategorieWords = new ArrayCollection();
        $this->pageOrders = new ArrayCollection();
        $this->userCategoriesOrders = new ArrayCollection();
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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): static
    {
        $this->filename = $filename;

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
     * @return Collection<int, Categories>
     */
    public function getCategoriesWord(): Collection
    {
        return $this->categoriesWord;
    }

    public function addCategoriesWord(Categories $categoriesWord): static
    {
        if (!$this->categoriesWord->contains($categoriesWord)) {
            $this->categoriesWord->add($categoriesWord);
        }

        return $this;
    }

    public function removeCategoriesWord(Categories $categoriesWord): static
    {
        $this->categoriesWord->removeElement($categoriesWord);

        return $this;
    }

    public function __toString(): String
    {
        return $this->name;
    }

    /**
     * @return Collection<int, WordTranslation>
     */
    public function getWordTranslations(): Collection
    {
        return $this->wordTranslations;
    }

    public function getWordTranslationsByLang(string $lang): string
    {
        $langId = (int)$lang;
        $res = $this->getWordTranslations()->filter(function(WordTranslation $wordsTranslations) use ($langId) {
            return $wordsTranslations->getLang()->getId() == $langId;
        });
        foreach ($res as $wordTranslation) {
            return $wordTranslation->getName();
        }
        return $this->name;
    }

    public function addWordTranslation(WordTranslation $wordTranslation): static
    {
        if (!$this->wordTranslations->contains($wordTranslation)) {
            $this->wordTranslations->add($wordTranslation);
            $wordTranslation->setWordTranslation($this);
        }

        return $this;
    }

    public function removeWordTranslation(WordTranslation $wordTranslation): static
    {
        if ($this->wordTranslations->removeElement($wordTranslation)) {
            // set the owning side to null (unless already changed)
            if ($wordTranslation->getWordTranslation() === $this) {
                $wordTranslation->setWordTranslation(null);
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
            $sentence->addSentencesWord($this);
        }

        return $this;
    }

    public function removeSentence(Sentences $sentence): static
    {
        if ($this->sentences->removeElement($sentence)) {
            $sentence->removeSentencesWord($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getNextCategories(): Collection
    {
        return $this->nextCategories;
    }

    public function addNextCategory(Categories $nextCategory): static
    {
        if (!$this->nextCategories->contains($nextCategory)) {
            $this->nextCategories->add($nextCategory);
        }

        return $this;
    }

    public function removeNextCategory(Categories $nextCategory): static
    {
        $this->nextCategories->removeElement($nextCategory);

        return $this;
    }

    /**
     * @return Collection<int, UserCategorieWords>
     */
    public function getUserCategorieWords(): Collection
    {
        return $this->userCategorieWords;
    }

    public function addUserCategorieWord(UserCategorieWords $userCategorieWord): static
    {
        if (!$this->userCategorieWords->contains($userCategorieWord)) {
            $this->userCategorieWords->add($userCategorieWord);
            $userCategorieWord->setWord($this);
        }

        return $this;
    }

    public function removeUserCategorieWord(UserCategorieWords $userCategorieWord): static
    {
        if ($this->userCategorieWords->removeElement($userCategorieWord)) {
            // set the owning side to null (unless already changed)
            if ($userCategorieWord->getWord() === $this) {
                $userCategorieWord->setWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PageOrder>
     */
    public function getPageOrders(): Collection
    {
        return $this->pageOrders;
    }

    public function addPageOrder(PageOrder $pageOrder): static
    {
        if (!$this->pageOrders->contains($pageOrder)) {
            $this->pageOrders->add($pageOrder);
            $pageOrder->setWord($this);
        }

        return $this;
    }

    public function removePageOrder(PageOrder $pageOrder): static
    {
        if ($this->pageOrders->removeElement($pageOrder)) {
            // set the owning side to null (unless already changed)
            if ($pageOrder->getWord() === $this) {
                $pageOrder->setWord(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, UserCategoriesOrder>
     */
    public function getUserCategoriesOrders(): Collection
    {
        return $this->userCategoriesOrders;
    }

    public function addUserCategoriesOrder(UserCategoriesOrder $userCategoriesOrder): static
    {
        if (!$this->userCategoriesOrders->contains($userCategoriesOrder)) {
            $this->userCategoriesOrders->add($userCategoriesOrder);
            $userCategoriesOrder->setWord($this);
        }

        return $this;
    }

    public function removeUserCategoriesOrder(UserCategoriesOrder $userCategoriesOrder): static
    {
        if ($this->userCategoriesOrders->removeElement($userCategoriesOrder)) {
            // set the owning side to null (unless already changed)
            if ($userCategoriesOrder->getWord() === $this) {
                $userCategoriesOrder->setWord(null);
            }
        }

        return $this;
    }

    public function getArasaac(): ?int
    {
        return $this->arasaac;
    }

    public function setArasaac(?int $arasaac): static
    {
        $this->arasaac = $arasaac;

        return $this;
    }

    public function getType(): ?WordConfiguration
    {
        return $this->type;
    }

    public function setType(?WordConfiguration $type): static
    {
        $this->type = $type;

        return $this;
    }

}

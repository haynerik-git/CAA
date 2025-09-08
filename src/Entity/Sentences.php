<?php

namespace App\Entity;

use App\Repository\SentencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SentencesRepository::class)]
class Sentences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2500)]
    private ?string $name = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $filename = null;

    #[ORM\Column]
    private ?int $display_order = null;

    #[ORM\OneToMany(targetEntity: SentencesTranslation::class, mappedBy: 'sentenceTranslation')]
    private Collection $sentencesTranslations;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'sentences')]
    private Collection $categoriesSentences;

    #[ORM\ManyToMany(targetEntity: Word::class, inversedBy: 'sentences')]
    private Collection $sentencesWord;

    #[ORM\ManyToOne(inversedBy: 'sentences')]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: PageOrder::class, mappedBy: 'sentence')]
    private Collection $pageOrders;

    #[ORM\OneToMany(targetEntity: UserCategoriesOrder::class, mappedBy: 'sentence')]
    private Collection $userCategoriesOrders;

    public function __construct()
    {
        $this->sentencesTranslations = new ArrayCollection();
        $this->categoriesSentences = new ArrayCollection();
        $this->sentencesWord = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
     * @return Collection<int, SentencesTranslation>
     */
    public function getSentencesTranslations(): Collection
    {
        return $this->sentencesTranslations;
    }

    public function getSentencesTranslationsFilterByLang(): Collection
    {
        return $this->sentencesTranslations;
    }

    public function addSentencesTranslation(SentencesTranslation $sentencesTranslation): static
    {
        if (!$this->sentencesTranslations->contains($sentencesTranslation)) {
            $this->sentencesTranslations->add($sentencesTranslation);
            $sentencesTranslation->setSentenceTranslation($this);
        }

        return $this;
    }

    public function removeSentencesTranslation(SentencesTranslation $sentencesTranslation): static
    {
        if ($this->sentencesTranslations->removeElement($sentencesTranslation)) {
            // set the owning side to null (unless already changed)
            if ($sentencesTranslation->getSentenceTranslation() === $this) {
                $sentencesTranslation->setSentenceTranslation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategoriesSentences(): Collection
    {
        return $this->categoriesSentences;
    }

    public function addCategoriesSentence(Categories $categoriesSentence): static
    {
        if (!$this->categoriesSentences->contains($categoriesSentence)) {
            $this->categoriesSentences->add($categoriesSentence);
        }

        return $this;
    }

    public function removeCategoriesSentence(Categories $categoriesSentence): static
    {
        $this->categoriesSentences->removeElement($categoriesSentence);

        return $this;
    }

    /**
     * @return Collection<int, Word>
     */
    public function getSentencesWord(): Collection
    {
        return $this->sentencesWord;
    }

    public function addSentencesWord(Word $sentencesWord): static
    {
        if (!$this->sentencesWord->contains($sentencesWord)) {
            $this->sentencesWord->add($sentencesWord);
        }

        return $this;
    }

    public function removeSentencesWord(Word $sentencesWord): static
    {
        $this->sentencesWord->removeElement($sentencesWord);

        return $this;
    }

    public function __toString(): String
    {
        return $this->name;
    }


    public function getSentenceTranslationsByLang(string $lang): string
    {
        $langId = (int)$lang;
        $res = $this->getSentencesTranslations()->filter(function(SentencesTranslation $wordsTranslations) use ($langId) {
            return $wordsTranslations->getLang()->getId() == $langId;
        });
        foreach ($res as $wordTranslation) {
            return $wordTranslation->getSentence();
        }
        return $this->name;
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
            $pageOrder->setSentence($this);
        }

        return $this;
    }

    public function removePageOrder(PageOrder $pageOrder): static
    {
        if ($this->pageOrders->removeElement($pageOrder)) {
            // set the owning side to null (unless already changed)
            if ($pageOrder->getSentence() === $this) {
                $pageOrder->setSentence(null);
            }
        }

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
            $userCategoriesOrder->setSentence($this);
        }

        return $this;
    }

    public function removeUserCategoriesOrder(UserCategoriesOrder $userCategoriesOrder): static
    {
        if ($this->userCategoriesOrders->removeElement($userCategoriesOrder)) {
            // set the owning side to null (unless already changed)
            if ($userCategoriesOrder->getSentence() === $this) {
                $userCategoriesOrder->setSentence(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\LangRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangRepository::class)]
class Lang
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: WordTranslation::class, mappedBy: 'lang')]
    private Collection $wordTranslations;

    #[ORM\OneToMany(targetEntity: CategoriesTranslation::class, mappedBy: 'lang')]
    private Collection $categoriesTranslations;

    #[ORM\OneToMany(targetEntity: SentencesTranslation::class, mappedBy: 'lang')]
    private Collection $sentencesTranslations;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'lang')]
    private Collection $users;

    public function __construct()
    {
        $this->wordTranslations = new ArrayCollection();
        $this->categoriesTranslations = new ArrayCollection();
        $this->sentencesTranslations = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection<int, WordTranslation>
     */
    public function getWordTranslations(): Collection
    {
        return $this->wordTranslations;
    }

    public function addWordTranslation(WordTranslation $wordTranslation): static
    {
        if (!$this->wordTranslations->contains($wordTranslation)) {
            $this->wordTranslations->add($wordTranslation);
            $wordTranslation->setLang($this);
        }

        return $this;
    }

    public function removeWordTranslation(WordTranslation $wordTranslation): static
    {
        if ($this->wordTranslations->removeElement($wordTranslation)) {
            // set the owning side to null (unless already changed)
            if ($wordTranslation->getLang() === $this) {
                $wordTranslation->setLang(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
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
            $categoriesTranslation->setLang($this);
        }

        return $this;
    }

    public function removeCategoriesTranslation(CategoriesTranslation $categoriesTranslation): static
    {
        if ($this->categoriesTranslations->removeElement($categoriesTranslation)) {
            // set the owning side to null (unless already changed)
            if ($categoriesTranslation->getLang() === $this) {
                $categoriesTranslation->setLang(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SentencesTranslation>
     */
    public function getSentencesTranslations(): Collection
    {
        return $this->sentencesTranslations;
    }

    public function addSentencesTranslation(SentencesTranslation $sentencesTranslation): static
    {
        if (!$this->sentencesTranslations->contains($sentencesTranslation)) {
            $this->sentencesTranslations->add($sentencesTranslation);
            $sentencesTranslation->setLang($this);
        }

        return $this;
    }

    public function removeSentencesTranslation(SentencesTranslation $sentencesTranslation): static
    {
        if ($this->sentencesTranslations->removeElement($sentencesTranslation)) {
            // set the owning side to null (unless already changed)
            if ($sentencesTranslation->getLang() === $this) {
                $sentencesTranslation->setLang(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setLang($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLang() === $this) {
                $user->setLang(null);
            }
        }

        return $this;
    }
}

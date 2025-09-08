<?php

namespace App\Entity;

use App\Repository\WordConfigurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordConfigurationRepository::class)]
class WordConfiguration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2500)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\OneToMany(targetEntity: Word::class, mappedBy: 'type')]
    private Collection $words;

    #[ORM\OneToMany(targetEntity: UserCategories::class, mappedBy: 'type')]
    private Collection $userCategories;

    public function __construct()
    {
        $this->words = new ArrayCollection();
        $this->userCategories = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Word>
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function addWord(Word $word): static
    {
        if (!$this->words->contains($word)) {
            $this->words->add($word);
            $word->setType($this);
        }

        return $this;
    }

    public function removeWord(Word $word): static
    {
        if ($this->words->removeElement($word)) {
            // set the owning side to null (unless already changed)
            if ($word->getType() === $this) {
                $word->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCategories>
     */
    public function getUserCategories(): Collection
    {
        return $this->userCategories;
    }

    public function addUserCategory(UserCategories $userCategory): static
    {
        if (!$this->userCategories->contains($userCategory)) {
            $this->userCategories->add($userCategory);
            $userCategory->setType($this);
        }

        return $this;
    }

    public function removeUserCategory(UserCategories $userCategory): static
    {
        if ($this->userCategories->removeElement($userCategory)) {
            // set the owning side to null (unless already changed)
            if ($userCategory->getType() === $this) {
                $userCategory->setType(null);
            }
        }

        return $this;
    }
}

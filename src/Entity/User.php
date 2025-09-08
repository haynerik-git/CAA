<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lang $lang = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\OneToMany(targetEntity: UserCategories::class, mappedBy: 'userId', orphanRemoval: true)]
    private Collection $userCategories;

    #[ORM\OneToMany(targetEntity: Sentences::class, mappedBy: 'user')]
    private Collection $sentences;

    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $pages;

    #[ORM\OneToMany(targetEntity: Word::class, mappedBy: 'user')]
    private Collection $words;

    #[ORM\OneToMany(targetEntity: Youtube::class, mappedBy: 'user')]
    private Collection $youtubes;

    public function __construct()
    {
        $this->userCategories = new ArrayCollection();
        $this->sentences = new ArrayCollection();
        $this->pages = new ArrayCollection();
        $this->words = new ArrayCollection();
        $this->youtubes = new ArrayCollection();
    }

    public function __toString(): String
    {
        return $this->login;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getLang(): ?Lang
    {
        return $this->lang;
    }

    public function setLang(?Lang $lang): static
    {
        $this->lang = $lang;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

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
            $userCategory->setUserId($this);
        }

        return $this;
    }

    public function removeUserCategory(UserCategories $userCategory): static
    {
        if ($this->userCategories->removeElement($userCategory)) {
            // set the owning side to null (unless already changed)
            if ($userCategory->getUserId() === $this) {
                $userCategory->setUserId(null);
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
            $sentence->setUser($this);
        }

        return $this;
    }

    public function removeSentence(Sentences $sentence): static
    {
        if ($this->sentences->removeElement($sentence)) {
            // set the owning side to null (unless already changed)
            if ($sentence->getUser() === $this) {
                $sentence->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->setUser($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getUser() === $this) {
                $page->setUser(null);
            }
        }

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
            $word->setUser($this);
        }

        return $this;
    }

    public function removeWord(Word $word): static
    {
        if ($this->words->removeElement($word)) {
            // set the owning side to null (unless already changed)
            if ($word->getUser() === $this) {
                $word->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Youtube>
     */
    public function getYoutubes(): Collection
    {
        return $this->youtubes;
    }

    public function addYoutube(Youtube $youtube): static
    {
        if (!$this->youtubes->contains($youtube)) {
            $this->youtubes->add($youtube);
            $youtube->setUser($this);
        }

        return $this;
    }

    public function removeYoutube(Youtube $youtube): static
    {
        if ($this->youtubes->removeElement($youtube)) {
            // set the owning side to null (unless already changed)
            if ($youtube->getUser() === $this) {
                $youtube->setUser(null);
            }
        }

        return $this;
    }
}

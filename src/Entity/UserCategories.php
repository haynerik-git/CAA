<?php

namespace App\Entity;

use App\Repository\UserCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCategoriesRepository::class)]
class UserCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3000)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'userCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(nullable: true)]
    private ?int $display_order = null;

    #[ORM\Column(nullable: true)]
    private ?int $displayOrderSentences = null;

    #[ORM\OneToMany(targetEntity: UserCategorieWords::class, mappedBy: 'categorie', orphanRemoval: true)]
    private Collection $userCategorieWords;

    #[ORM\OneToMany(targetEntity: PageOrder::class, mappedBy: 'userCategories')]
    private Collection $pageOrders;

    #[ORM\OneToMany(targetEntity: UserCategoriesOrder::class, mappedBy: 'categorie')]
    private Collection $userCategoriesOrders;

    #[ORM\ManyToOne(inversedBy: 'userCategories')]
    private ?WordConfiguration $type = null;

    public function __construct()
    {
        $this->userCategorieWords = new ArrayCollection();
        $this->pageOrders = new ArrayCollection();
        $this->userCategoriesOrders = new ArrayCollection();
    }


    public function __toString(): String
    {
        return $this->label;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->display_order;
    }

    public function setDisplayOrder(?int $display_order): static
    {
        $this->display_order = $display_order;

        return $this;
    }

    public function getDisplayOrderSentences(): ?int
    {
        return $this->displayOrderSentences;
    }

    public function setDisplayOrderSentences(?int $displayOrderSentences): static
    {
        $this->displayOrderSentences = $displayOrderSentences;

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
            $userCategorieWord->setCategorie($this);
        }

        return $this;
    }

    public function removeUserCategorieWord(UserCategorieWords $userCategorieWord): static
    {
        if ($this->userCategorieWords->removeElement($userCategorieWord)) {
            // set the owning side to null (unless already changed)
            if ($userCategorieWord->getCategorie() === $this) {
                $userCategorieWord->setCategorie(null);
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
            $pageOrder->setUserCategories($this);
        }

        return $this;
    }

    public function removePageOrder(PageOrder $pageOrder): static
    {
        if ($this->pageOrders->removeElement($pageOrder)) {
            // set the owning side to null (unless already changed)
            if ($pageOrder->getUserCategories() === $this) {
                $pageOrder->setUserCategories(null);
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
            $userCategoriesOrder->setCategorie($this);
        }

        return $this;
    }

    public function removeUserCategoriesOrder(UserCategoriesOrder $userCategoriesOrder): static
    {
        if ($this->userCategoriesOrders->removeElement($userCategoriesOrder)) {
            // set the owning side to null (unless already changed)
            if ($userCategoriesOrder->getCategorie() === $this) {
                $userCategoriesOrder->setCategorie(null);
            }
        }

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

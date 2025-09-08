<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3000)]
    private ?string $title = null;

    #[ORM\Column(length: 3000)]
    private ?string $actionJS = null;

    #[ORM\OneToMany(targetEntity: PageOrder::class, mappedBy: 'action')]
    private Collection $pageOrders;

    #[ORM\OneToMany(targetEntity: UserCategoriesOrder::class, mappedBy: 'action')]
    private Collection $userCategoriesOrders;

    public function __construct()
    {
        $this->pageOrders = new ArrayCollection();
        $this->userCategoriesOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getActionJS(): ?string
    {
        return $this->actionJS;
    }

    public function setActionJS(string $actionJS): static
    {
        $this->actionJS = $actionJS;

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
            $pageOrder->setAction($this);
        }

        return $this;
    }

    public function removePageOrder(PageOrder $pageOrder): static
    {
        if ($this->pageOrders->removeElement($pageOrder)) {
            // set the owning side to null (unless already changed)
            if ($pageOrder->getAction() === $this) {
                $pageOrder->setAction(null);
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
            $userCategoriesOrder->setAction($this);
        }

        return $this;
    }

    public function removeUserCategoriesOrder(UserCategoriesOrder $userCategoriesOrder): static
    {
        if ($this->userCategoriesOrders->removeElement($userCategoriesOrder)) {
            // set the owning side to null (unless already changed)
            if ($userCategoriesOrder->getAction() === $this) {
                $userCategoriesOrder->setAction(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserCategoriesOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCategoriesOrderRepository::class)]
class UserCategoriesOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3000)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'userCategoriesOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserCategories $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'userCategoriesOrders')]
    private ?Word $word = null;

    #[ORM\ManyToOne(inversedBy: 'userCategoriesOrders')]
    private ?Sentences $sentence = null;

    #[ORM\ManyToOne(inversedBy: 'userCategoriesOrders')]
    private ?Action $action = null;

    #[ORM\ManyToOne(inversedBy: 'userCategoriesOrders')]
    private ?Youtube $youtube = null;

    #[ORM\ManyToOne(inversedBy: 'userCategoriesOrders')]
    private ?UserCategories $nextCategorie = null;

    #[ORM\Column]
    private ?int $orderDisplay = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sizeCell = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCategorie(): ?UserCategories
    {
        return $this->categorie;
    }

    public function setCategorie(?UserCategories $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function getSentence(): ?Sentences
    {
        return $this->sentence;
    }

    public function setSentence(?Sentences $sentence): static
    {
        $this->sentence = $sentence;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getYoutube(): ?Youtube
    {
        return $this->youtube;
    }

    public function setYoutube(?Youtube $youtube): static
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getUserCategories(): ?UserCategories
    {
        return $this->nextCategorie;
    }
    public function getNextCategorie(): ?UserCategories
    {
        return $this->nextCategorie;
    }

    public function setNextCategorie(?UserCategories $nextCategorie): static
    {
        $this->nextCategorie = $nextCategorie;

        return $this;
    }

    public function getOrderDisplay(): ?int
    {
        return $this->orderDisplay;
    }

    public function setOrderDisplay(int $orderDisplay): static
    {
        $this->orderDisplay = $orderDisplay;

        return $this;
    }

    public function getSizeCell(): ?string
    {
        return $this->sizeCell;
    }

    public function setSizeCell(?string $sizeCell): static
    {
        $this->sizeCell = $sizeCell;

        return $this;
    }
}

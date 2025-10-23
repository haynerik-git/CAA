<?php

namespace App\Entity;

use App\Repository\PageOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageOrderRepository::class)]
class PageOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pageOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $page = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $targetId = null;

    #[ORM\Column]
    private ?int $order_display = null;

    #[ORM\ManyToOne(inversedBy: 'pageOrders')]
    private ?Word $word = null;

    #[ORM\ManyToOne(inversedBy: 'pageOrders')]
    private ?UserCategories $userCategories = null;

    #[ORM\ManyToOne(inversedBy: 'pageOrders')]
    private ?Sentences $sentence = null;

    #[ORM\ManyToOne(inversedBy: 'pageOrders')]
    private ?Youtube $youtube = null;

    #[ORM\ManyToOne(inversedBy: 'pageOrders')]
    private ?Action $action = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sizeCell = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $background = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hidden = null;

    #[ORM\ManyToOne(inversedBy: 'pagePictoOrders')]
    private ?Page $pagePicto = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): static
    {
        $this->page = $page;

        return $this;
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

    public function getTargetId(): ?int
    {
        return $this->targetId;
    }

    public function setTargetId(int $targetId): static
    {
        $this->targetId = $targetId;

        return $this;
    }

    public function getOrderDisplay(): ?int
    {
        return $this->order_display;
    }

    public function setOrderDisplay(int $order_display): static
    {
        $this->order_display = $order_display;

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

    public function getUserCategories(): ?UserCategories
    {
        return $this->userCategories;
    }

    public function setUserCategories(?UserCategories $userCategories): static
    {
        $this->userCategories = $userCategories;

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

    public function getYoutube(): ?Youtube
    {
        return $this->youtube;
    }

    public function setYoutube(?Youtube $youtube): static
    {
        $this->youtube = $youtube;

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

    public function getSizeCell(): ?string
    {
        return $this->sizeCell;
    }

    public function setSizeCell(?string $sizeCell): static
    {
        $this->sizeCell = $sizeCell;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): static
    {
        $this->background = $background;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function isHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): static
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getPagePicto(): ?Page
    {
        return $this->pagePicto;
    }

    public function setPagePicto(?Page $pagePicto): static
    {
        $this->pagePicto = $pagePicto;

        return $this;
    }
    
}

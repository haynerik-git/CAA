<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3000)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbCol = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbRow = null;

    #[ORM\ManyToOne(inversedBy: 'pages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: PageOrder::class, mappedBy: 'page', orphanRemoval: true)]
    private Collection $pageOrders;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $background = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $font = null;

    #[ORM\Column(length: 3000, nullable: true)]
    private ?string $filename = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backgroundCell = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backgroundTab = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $border = null;

    #[ORM\Column]
    private ?bool $autoSpeak = null;

    public function __construct()
    {
        $this->pageOrders = new ArrayCollection();
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

    public function getNbCol(): ?int
    {
        return $this->nbCol;
    }

    public function setNbCol(?int $NbCol): static
    {
        $this->nbCol = $NbCol;

        return $this;
    }

    public function getNbRow(): ?int
    {
        return $this->nbRow;
    }

    public function setNbRow(?int $nbRow): static
    {
        $this->nbRow = $nbRow;

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
            $pageOrder->setPage($this);
        }

        return $this;
    }

    public function removePageOrder(PageOrder $pageOrder): static
    {
        if ($this->pageOrders->removeElement($pageOrder)) {
            // set the owning side to null (unless already changed)
            if ($pageOrder->getPage() === $this) {
                $pageOrder->setPage(null);
            }
        }

        return $this;
    }

    public function __toString(): String
    {
        return $this->title;
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

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(?string $font): static
    {
        $this->font = $font;

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

    public function getBackgroundCell(): ?string
    {
        return $this->backgroundCell;
    }

    public function setBackgroundCell(?string $backgroundCell): static
    {
        $this->backgroundCell = $backgroundCell;

        return $this;
    }

    public function getBackgroundTab(): ?string
    {
        return $this->backgroundTab;
    }

    public function setBackgroundTab(?string $backgroundTab): static
    {
        $this->backgroundTab = $backgroundTab;

        return $this;
    }

    public function getColorDescription(): ?string
    {
        return $this->colorDescription;
    }

    public function setColorDescription(?string $colorDescription): static
    {
        $this->colorDescription = $colorDescription;

        return $this;
    }

    public function getBorder(): ?string
    {
        return $this->border;
    }

    public function setBorder(?string $border): static
    {
        $this->border = $border;

        return $this;
    }

    public function isAutoSpeak(): ?bool
    {
        return $this->autoSpeak;
    }

    public function setAutoSpeak(bool $autoSpeak): static
    {
        $this->autoSpeak = $autoSpeak;

        return $this;
    }
}

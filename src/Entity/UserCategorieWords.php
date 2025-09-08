<?php

namespace App\Entity;

use App\Repository\UserCategorieWordsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCategorieWordsRepository::class)]
class UserCategorieWords
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'userCategorieWords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserCategories $categorie = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(nullable: true)]
    private ?int $display_order = null;

    #[ORM\ManyToOne(inversedBy: 'userCategorieWords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $word = null;

    public function __construct()
    {
  //      $this->word = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function __toString(): String
    {
        return $this->word->getName();
    }

}

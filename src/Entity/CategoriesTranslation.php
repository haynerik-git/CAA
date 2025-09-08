<?php

namespace App\Entity;

use App\Repository\CategoriesTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesTranslationRepository::class)]
class CategoriesTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2500)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'categoriesTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lang $lang = null;

    #[ORM\ManyToOne(inversedBy: 'categoriesTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categoriesTranslation = null;

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

    public function getLang(): ?Lang
    {
        return $this->lang;
    }

    public function setLang(?Lang $lang): static
    {
        $this->lang = $lang;

        return $this;
    }

    public function getCategoriesTranslation(): ?Categories
    {
        return $this->categoriesTranslation;
    }

    public function setCategoriesTranslation(?Categories $categoriesTranslation): static
    {
        $this->categoriesTranslation = $categoriesTranslation;

        return $this;
    }

    public function __toString(): String
    {
        return $this->name;
    }
}

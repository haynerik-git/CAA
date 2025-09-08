<?php

namespace App\Entity;

use App\Repository\WordTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordTranslationRepository::class)]
class WordTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2500)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'wordTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $wordTranslation = null;

    #[ORM\ManyToOne(inversedBy: 'wordTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lang $lang = null;


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

    public function getWordTranslation(): ?Word
    {
        return $this->wordTranslation;
    }

    public function setWordTranslation(?Word $wordTranslation): static
    {
        $this->wordTranslation = $wordTranslation;

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

    public function __toString(): String
    {
        return $this->name;
    }
}

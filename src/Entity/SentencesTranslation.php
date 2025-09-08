<?php

namespace App\Entity;

use App\Repository\SentencesTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SentencesTranslationRepository::class)]
class SentencesTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2500)]
    private ?string $sentence = null;

    #[ORM\ManyToOne(inversedBy: 'sentencesTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lang $lang = null;

    #[ORM\ManyToOne(inversedBy: 'sentencesTranslations')]
    private ?Sentences $sentenceTranslation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSentence(): ?string
    {
        return $this->sentence;
    }

    public function setSentence(string $sentence): static
    {
        $this->sentence = $sentence;

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

    public function getSentenceTranslation(): ?Sentences
    {
        return $this->sentenceTranslation;
    }

    public function setSentenceTranslation(?Sentences $sentenceTranslation): static
    {
        $this->sentenceTranslation = $sentenceTranslation;

        return $this;
    }

    public function __toString(): String
    {
        return $this->sentence;
    }
}

<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionLogique::class, inversedBy="reponses")
     */
    private $questionLogique;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionChoixMultiples::class, inversedBy="reponses")
     */
    private $questionChoixMultiples;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reponses")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getQuestionLogique(): ?QuestionLogique
    {
        return $this->questionLogique;
    }

    public function setQuestionLogique(?QuestionLogique $questionLogique): self
    {
        $this->questionLogique = $questionLogique;

        return $this;
    }

    public function getQuestionChoixMultiples(): ?QuestionChoixMultiples
    {
        return $this->questionChoixMultiples;
    }

    public function setQuestionChoixMultiples(?QuestionChoixMultiples $questionChoixMultiples): self
    {
        $this->questionChoixMultiples = $questionChoixMultiples;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

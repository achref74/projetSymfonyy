<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $ressource;

    #[ORM\Column(type: 'integer')]
    private int $duree;

    #[ORM\Column(type: 'integer')]
    private int $point;

    #[ORM\Column(type: 'string', length: 255)]
    private string $choix1;

    #[ORM\Column(type: 'string', length: 255)]
    private string $choix2;

    #[ORM\Column(type: 'string', length: 255)]
    private string $choix3;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $reponse;

    #[ORM\Column(type: 'string', length: 255)]
    private string $crx;

    #[ORM\ManyToOne(targetEntity: Evaluation::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private Evaluation $evaluation;

    public function getId(): ?int
    {
        return $this->id;
    }

    // Existing getters and setters...

    public function getRessource(): string
    {
        return $this->ressource;
    }

    public function setRessource(string $ressource): self
    {
        $this->ressource = $ressource;

        return $this;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getChoix1(): string
    {
        return $this->choix1;
    }

    public function setChoix1(string $choix1): self
    {
        $this->choix1 = $choix1;

        return $this;
    }

    public function getChoix2(): string
    {
        return $this->choix2;
    }

    public function setChoix2(string $choix2): self
    {
        $this->choix2 = $choix2;

        return $this;
    }

    public function getChoix3(): string
    {
        return $this->choix3;
    }

    public function setChoix3(string $choix3): self
    {
        $this->choix3 = $choix3;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getCrx(): string
    {
        return $this->crx;
    }

    public function setCrx(string $crx): self
    {
        $this->crx = $crx;

        return $this;
    }

    public function getEvaluation(): Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }
}

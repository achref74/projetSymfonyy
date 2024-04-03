<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
#[ORM\Entity(repositoryClass: QuestionRepository::class)]

class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_q", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_q", type: "integer")]
    private $idQ;

    /**
     * @ORM\Column(name="ressource", type="string", length=255)
     */
    #[ORM\Column(name: "ressource", type: "string", length: 255)]
    private $ressource;

    /**
     * @ORM\Column(name="duree", type="integer")
     */
    #[ORM\Column(name: "duree", type: "integer")]
    private $duree;

    /**
     * @ORM\Column(name="point", type="integer")
     */
    #[ORM\Column(name: "point", type: "integer")]
    private $point;

    /**
     * @ORM\Column(name="choix1", type="string", length=255)
     */
    #[ORM\Column(name: "choix1", type: "string", length: 255)]
    private $choix1;

    /**
     * @ORM\Column(name="choix2", type="string", length=255)
     */
    #[ORM\Column(name: "choix2", type: "string", length: 255)]
    private $choix2;

    /**
     * @ORM\Column(name="choix3", type="string", length=255)
     */
    #[ORM\Column(name: "choix3", type: "string", length: 255)]
    private $choix3;

    /**
     * @ORM\Column(name="reponse", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "reponse", type: "string", length: 255, nullable: true)]
    private $reponse;

    /**
     * @ORM\Column(name="crx", type="string", length=255)
     */
    #[ORM\Column(name: "crx", type: "string", length:
     255)]
    private $crx;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evaluation")
     * @ORM\JoinColumn(name="id_e", referencedColumnName="id_e")
     */
    #[ORM\ManyToOne(targetEntity: Evaluation::class)]
    #[ORM\JoinColumn(name: "id_e", referencedColumnName: "id_e")]
    private $idE;

    // Getters and setters...

    public function getIdQ(): ?int
    {
        return $this->idQ;
    }

    public function getRessource(): ?string
    {
        return $this->ressource;
    }

    public function setRessource(string $ressource): self
    {
        $this->ressource = $ressource;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getChoix1(): ?string
    {
        return $this->choix1;
    }

    public function setChoix1(string $choix1): self
    {
        $this->choix1 = $choix1;

        return $this;
    }

    public function getChoix2(): ?string
    {
        return $this->choix2;
    }

    public function setChoix2(string $choix2): self
    {
        $this->choix2 = $choix2;

        return $this;
    }

    public function getChoix3(): ?string
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

    public function getCrx(): ?string
    {
        return $this->crx;
    }

    public function setCrx(string $crx): self
    {
        $this->crx = $crx;

        return $this;
    }

    public function getIdE(): ?Evaluation
    {
        return $this->idE;
    }

    public function setIdE(?Evaluation $idE): self
    {
        $this->idE = $idE;

        return $this;
    }
}
?>
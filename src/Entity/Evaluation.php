<?php

namespace App\Entity;
use App\Repository\EvaluationRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="evaluation")
 * @ORM\Entity
 */

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]

class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_e", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_e", type: "integer")]
    private  $idE;

    /**
     * @ORM\Column(name="note", type="integer")
     */
    #[ORM\Column(name: "note", type: "integer")]
    private  $note;

    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private  $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours")
     * @ORM\JoinColumn(name="id_cours", referencedColumnName="id_cours")
     */
    #[ORM\ManyToOne(targetEntity: Cours::class)]
    #[ORM\JoinColumn(name: "id_cours", referencedColumnName: "id_cours")]
    private  $cours;

    public function getIdE(): ?int
    {
        return $this->idE;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}

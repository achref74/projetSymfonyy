<?php
namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $note;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nom;

    #[ORM\ManyToOne(targetEntity: Cours::class, inversedBy: 'evaluations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $cours;

    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'evaluation', cascade: ['persist', 'remove'])]
    private Collection $questions;

    
    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNom(): string
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

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setEvaluation($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getEvaluation() === $this) {
                $question->setEvaluation(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom; // Return the 'nom' property as a string representation
    }
}

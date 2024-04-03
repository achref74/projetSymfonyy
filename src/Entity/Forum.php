<?php

namespace App\Entity;
use App\Repository\ForumRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="forum")
 * @ORM\Entity
 */

#[ORM\Entity(repositoryClass: ForumRepository::class)]

class Forum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="idForum", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idForum", type: "integer")]
    private  $idForum;

    /**
     * @ORM\Column(name="titre", type="string", length=255)
     */
    #[ORM\Column(name: "titre", type: "string", length: 255)]
    private $titre;

    /**
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    #[ORM\Column(name: "dateCreation", type: "datetime")]
    private  $dateCreation;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    #[ORM\Column(name: "description", type: "string", length: 255)]
    private  $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(name="idFormation", referencedColumnName="idFormation")
     */
    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(name: "idFormation", referencedColumnName: "idFormation")]
    private  $formation;

    public function getIdForum(): ?int
    {
        return $this->idForum;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
}

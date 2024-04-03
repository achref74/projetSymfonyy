<?php

namespace App\Entity;
use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $description;

    /**
     * @ORM\Column(type="date")
     */
    #[ORM\Column(type: "date")]
    private  $date;

    /**
     * @ORM\Column(type="integer")
     */
    #[ORM\Column(type: "integer")]
    private  $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $prerequis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $ressource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(nullable=false, name="idFormation", referencedColumnName="idFormation")
     */
    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(nullable: false, name: "idFormation", referencedColumnName: "idFormation")]
    private  $formation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getPrerequis(): ?string
    {
        return $this->prerequis;
    }

    public function setPrerequis(string $prerequis): self
    {
        $this->prerequis = $prerequis;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

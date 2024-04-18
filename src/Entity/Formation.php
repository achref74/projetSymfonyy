<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormationRepository;
/**
 * @ORM\Table(name="formation")
 * @ORM\Entity
 */
#[ORM\Table(name:"formation")]
#[ORM\Entity(repositoryClass: FormationRepository::class)]

class Formation
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"idFormation" ,type: "integer")]
    private      $idFormation;

    
    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private  $nom;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    #[ORM\Column(name: "description", type: "string", length: 255)]
    private  $description;

    /**
     * @ORM\Column(name="dateD", type="date")
     */
    #[ORM\Column(name: "dateD", type: "date")]
    private  $dateD;

    /**
     * @ORM\Column(name="dateF", type="date")
     */
    #[ORM\Column(name: "dateF", type: "date")]
    private  $dateF;

    /**
     * @ORM\Column(name="prix", type="float")
     */
    #[ORM\Column(name: "prix", type: "float")]
    private  $prix;

    /**
     * @ORM\Column(name="nbrCours", type="integer")
     */
    #[ORM\Column(name: "nbrCours", type: "integer")]
    private  $nbrCours;

    /**
     * @ORM\Column(name="imageUrl", type="string", length=255)
     */
    #[ORM\Column(name: "imageUrl", type: "string", length: 255)]
    private  $imageUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
    private  $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie")
     * @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie")
     */
    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: "idCategorie", referencedColumnName: "idCategorie")]
    private  $categorie;

    public function getIdFormation(): ?int
    {
        return $this->idFormation;
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

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(\DateTimeInterface $dateF): self
    {
        $this->dateF = $dateF;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrCours(): ?int
    {
        return $this->nbrCours;
    }

    public function setNbrCours(int $nbrCours): self
    {
        $this->nbrCours = $nbrCours;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}

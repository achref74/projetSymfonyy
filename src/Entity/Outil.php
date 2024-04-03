<?php

namespace App\Entity;
use App\Repository\OutilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="outil")
 * @ORM\Entity
 */

#[ORM\Entity(repositoryClass: OutilRepository::class)]

class Outil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="idoutils", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idoutils", type: "integer")]
    private  $idoutils;

    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private  $nom;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    #[ORM\Column(name: "description", type: "string", length: 255)]
    private  $description;

    /**
     * @ORM\Column(name="prix", type="float", precision=10, scale=0)
     */
    #[ORM\Column(name: "prix", type: "float", precision: 10, scale: 0)]
    private $prix;

    /**
     * @ORM\Column(name="ressources", type="string", length=255)
     */
    #[ORM\Column(name: "ressources", type: "string", length: 255)]
    private  $ressources;

    /**
     * @ORM\Column(name="stock", type="string", length=255)
     */
    #[ORM\Column(name: "stock", type: "string", length: 255)]
    private  $stock;

    /**
     * @ORM\Column(name="etat", type="string", length=255)
     */
    #[ORM\Column(name: "etat", type: "string", length: 255)]
    private  $etat;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    #[ORM\Column(name: "image", type: "string", length: 255)]
    private  $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie")
     * @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie")
     */
    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: "idCategorie", referencedColumnName: "idCategorie")]
    private  $categorie;

    public function getIdoutils(): ?int
    {
        return $this->idoutils;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRessources(): ?string
    {
        return $this->ressources;
    }

    public function setRessources(string $ressources): self
    {
        $this->ressources = $ressources;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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

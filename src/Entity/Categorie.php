<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\CategorieRepository;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"idCategorie",type:"integer")]
    private $idCategorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;
    // Getter et setter pour l'ID
    public function getId(): ?int
    {
        return $this->id;
    }
    // Getter et setter pour le nom
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    // Getter et setter pour la description
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }
}

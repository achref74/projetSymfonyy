<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{       
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idFormation',type:"integer")]

    private ?int $idformation = null;

    #[ORM\Column(name:"nom",type:"string",length: 255)]
    private ?string $nom = null;

    #[ORM\Column(name:"description",type:"string",length: 255)]
    private ?string $description = null;

    #[ORM\Column(name:"dateD",type: Types::DATETIME_MUTABLE, nullable: true)] 
    private ?\DateTimeInterface $dated = null;

    #[ORM\Column(name:"dateF",type: Types::DATETIME_MUTABLE, nullable: true)] 
    private ?\DateTimeInterface $datef= null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $nbrcours = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[ORM\JoinColumn(name: 'idCategorie', referencedColumnName: 'idCategorie')]
    private ?Categorie $categorie = null;
    
    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }
    
    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;
    
        return $this;
    }
    



    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
    private ?User $user = null;
    
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(?User $user): self
    {
        $this->user = $user;
    
        return $this;
    }
    

    public function getIdformation(): ?int
    {
        return $this->idformation;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(\DateTimeInterface $dated): static
    {
        $this->dated = $dated;

        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeInterface $datef): static
    {
        $this->datef = $datef;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrcours(): ?int
    {
        return $this->nbrcours;
    }

    public function setNbrcours(int $nbrcours): static
    {
        $this->nbrcours = $nbrcours;

        return $this;
    }

    

}

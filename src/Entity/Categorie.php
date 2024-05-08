<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idCategorie")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The name cannot be empty.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The name must be at most 255 characters long."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The description cannot be empty.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The description must be at most 255 characters long."
    )]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: Outil::class, mappedBy: 'categories')]
    private Collection $outils;

    public function __construct()
    {
        $this->outils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Outil>
     */
    public function getOutils(): Collection
    {
        return $this->outils;
    }

    public function addOutil(Outil $outil): self
    {
        if (!$this->outils->contains($outil)) {
            $this->outils->add($outil);
            $outil->setCategories($this);
        }

        return $this;
    }

    public function removeOutil(Outil $outil): self
    {
        if ($this->outils->removeElement($outil)) {
            // set the owning side to null (unless already changed)
            if ($outil->getCategories() === $this) {
                $outil->setCategories(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom ;
    }
}
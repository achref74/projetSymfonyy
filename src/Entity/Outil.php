<?php


namespace App\Entity;

use App\Repository\OutilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OutilRepository::class)]
class Outil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"idoutils")]
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

    #[ORM\Column]
    #[Assert\NotBlank(message: "The price cannot be empty.")]
    #[Assert\Positive(message: "The price must be a positive number.")]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The ressources cannot be empty.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The resources field must be at most 255 characters long."
    )]
    private ?string $ressources = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The stock cannot be empty.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The stock must be at most 255 characters long."
    )]
    private ?string $stock = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The etat cannot be empty.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The state must be at most 255 characters long."
    )]
    private ?string $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'outils')]
    #[Assert\NotBlank(message: "The categorie cannot be empty.")]
    private ?Categorie $categories = null;

    #[ORM\OneToMany(targetEntity: Achat::class, mappedBy: 'idOutil')]
    private Collection $achats;

    public function __construct()
    {
        $this->achats = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRessources(): ?string
    {
        return $this->ressources;
    }

    public function setRessources(?string $ressources): self
    {
        $this->ressources = $ressources;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(?string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, Achat>
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(Achat $achat): self
    {
        if (!$this->achats->contains($achat)) {
            $this->achats->add($achat);
            $achat->setOutil($this);
        }

        return $this;
    }

    public function removeAchat(Achat $achat): self
    {
        if ($this->achats->removeElement($achat)) {
            // set the owning side to null (unless already changed)
            if ($achat->getOutil() === $this) {
                $achat->setOutil(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom ;
    }

}
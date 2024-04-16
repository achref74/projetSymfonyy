<?php
namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="idFormation", type="integer")
     */
    private int $idFormation;

    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private string $nom;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(name="dated", type="date")
     */
    private \DateTimeInterface $dated;

    /**
     * @ORM\Column(name="datef", type="date")
     */
    private \DateTimeInterface $datef;

    /**
     * @ORM\Column(name="prix", type="float")
     */
    private float $prix;

    /**
     * @ORM\Column(name="nbrcours", type="integer")
     */
    private int $nbrcours;

    /**
     * @ORM\Column(name="imageurl", type="string", length=255)
     */
    private string $imageurl;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     */
    private ?User $iduser;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     * @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie")
     */
    private ?Categorie $idcategorie;

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

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(\DateTimeInterface $dated): self
    {
        $this->dated = $dated;
        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeInterface $datef): self
    {
        $this->datef = $datef;
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

    public function getNbrcours(): ?int
    {
        return $this->nbrcours;
    }

    public function setNbrcours(int $nbrcours): self
    {
        $this->nbrcours = $nbrcours;
        return $this;
    }

    public function getImageurl(): ?string
    {
        return $this->imageurl;
    }

    public function setImageurl(string $imageurl): self
    {
        $this->imageurl = $imageurl;
        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;
        return $this;
    }

    public function getIdcategorie(): ?Categorie
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?Categorie $idcategorie): self
    {
        $this->idcategorie = $idcategorie;
        return $this;
    }
}

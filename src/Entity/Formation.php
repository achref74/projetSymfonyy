<?php
namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
      * @Assert\NotBlank(message="Le nom est requis")
     */
    private $nom;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     * @Assert\NotBlank(message="La description est requise")
     */
    private $description;

    /**
     * @ORM\Column(name="dated", type="date")
     * @Assert\GreaterThan("today", message="The start date must be in the future")
    * @Assert\NotBlank(message="La date de début est requise")
     */
    private  $dated;

    /**
     * @ORM\Column(name="datef", type="date")
      * @Assert\NotBlank(message="The end date is required")
     * @Assert\GreaterThan("today", message="The end date must be in the future")
     
     * @Assert\GreaterThan(propertyPath="dateD", message="The end date must be greater than the start date")
     */
    private  $datef;

    /**
     * @ORM\Column(name="prix", type="float")
     * @Assert\NotBlank(message="Le prix est requis")
     * @Assert\GreaterThanOrEqual(value=0, message="The price must be a positive number or zero")
     * @Assert\Type(type="float", message="Le prix doit être un nombre décimal")
     */
    private $prix;

    /**
     * @ORM\Column(name="nbrcours", type="integer")
     * @Assert\NotBlank(message="Le nombre de cours est requis")
     * @Assert\GreaterThanOrEqual(value=1, message="The nbcours must be a positive number ")
     * @Assert\Type(type="integer", message="Le nombre de cours doit être un entier")
     */
    private $nbrcours;

    /**
     * @ORM\Column(name="imageurl", type="string", length=255)
     */
    private $imageurl;

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

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(?\DateTimeInterface $dated): self
    {
        $this->dated = $dated;
        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(?\DateTimeInterface $datef): self
    {
        $this->datef = $datef;
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

    public function getNbrcours(): ?int
    {
        return $this->nbrcours;
    }

    public function setNbrcours(?int $nbrcours): self
    {
        $this->nbrcours = $nbrcours;
        return $this;
    }

    public function getImageurl(): ?string
    {
        return $this->imageurl;
    }

    public function setImageurl(?string $imageurl): self
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

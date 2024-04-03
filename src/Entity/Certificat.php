<?php

namespace App\Entity;
use App\Repository\CertificatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CertificatRepository")
 */
#[ORM\Entity(repositoryClass: CertificatRepository::class)]
class Certificat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private  $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $description;

    /**
     * @ORM\Column(type="date")
     */
    #[ORM\Column(type: "date")]
    private  $dateObtention;

    /**
     * @ORM\Column(type="integer")
     */
    #[ORM\Column(type: "integer")]
    private  $nbrCours;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(nullable=false, name="idFormation", referencedColumnName="idFormation")
     */
    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(nullable: false, name: "idFormation", referencedColumnName: "idFormation")]
    private  $formation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false, name="idUser", referencedColumnName="idUser")
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, name: "idUser", referencedColumnName: "idUser")]
    private  $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateObtention(): ?\DateTimeInterface
    {
        return $this->dateObtention;
    }

    public function setDateObtention(\DateTimeInterface $dateObtention): self
    {
        $this->dateObtention = $dateObtention;

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

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

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
}

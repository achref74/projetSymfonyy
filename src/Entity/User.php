<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]

class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="idUser", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"idUser",type: "integer")]
    private  $idUser;

    /**
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $datenaissance;

    /**
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(name="numtel", type="integer")
     */
    private $numtel;

    /**
     * @ORM\Column(name="imageProfil", type="string", length=255, nullable=true)
     */
    private $imageprofil;

    /**
     * @ORM\Column(name="genre", type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(name="mdp", type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(name="role", type="integer")
     */
    private $role;

    /**
     * @ORM\Column(name="specialite", type="string", length=255, nullable=true)
     */
    private $specialite;

    /**
     * @ORM\Column(name="niveauAcademique", type="string", length=255, nullable=true)
     */
    private $niveauacademique;

    /**
     * @ORM\Column(name="disponiblite", type="integer", nullable=true)
     */
    private $disponiblite;

    /**
     * @ORM\Column(name="cv", type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(name="niveau_scolaire", type="string", length=50, nullable=true)
     */
    private $niveauScolaire;

    // Getters and setters...

    public function getIduser(): ?int
    {
        return $this->idUser;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getImageprofil(): ?string
    {
        return $this->imageprofil;
    }

    public function setImageprofil(?string $imageprofil): self
    {
        $this->imageprofil = $imageprofil;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getNiveauacademique(): ?string
    {
        return $this->niveauacademique;
    }

    public function setNiveauacademique(?string $niveauacademique): self
    {
        $this->niveauacademique = $niveauacademique;

        return $this;
    }

    public function getDisponiblite(): ?int
    {
        return $this->disponiblite;
    }

    public function setDisponiblite(?int $disponiblite): self
    {
        $this->disponiblite = $disponiblite;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getNiveauScolaire(): ?string
    {
        return $this->niveauScolaire;
    }

    public function setNiveauScolaire(?string $niveauScolaire): self
    {
        $this->niveauScolaire = $niveauScolaire;

        return $this;
    }
}


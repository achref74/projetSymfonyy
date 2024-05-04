<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{ 
    
 
    public const ROLE_CLIENT = 0;
    public const ROLE_FORMATEUR = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idUser")]
    private ?int $idUser = null;
    

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $authCode;

    #[ORM\Column(type: Types::DATE_MUTABLE, name: "dateNaissance")]
    private ?\DateTimeInterface $dateNaissance = null;
    

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $numtel = null;
    #[ORM\Column(name: "imageProfil", length: 255)]
    private ?string $imageProfil = null;
    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;
    #[ORM\Column]
    private ?int $role = null;

    #[ORM\Column]
    private ?int $activated = null;
    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 180)]
    private ?string $reset_token;

    #[ORM\Column(name: "niveauAcademique",length: 255)]
    private ?string $niveauAcademique = null;

    #[ORM\Column(name: "disponiblite")]
    private ?int $disponiblite = null;

    #[ORM\Column(length: 255)]
    private ?string $cv = null;

    #[ORM\Column(length: 20)]
    private ?string $otp = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau_scolaire = null;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    
    public function isEmailAuthEnabled(): bool
    {
        return true; // This can be a persisted field to switch email code authentication on/off
    }

    public function getEmailAuthRecipient(): string
    {
        return $this->email;
    }

    public function getEmailAuthCode(): string
    {
        if (null === $this->authCode) {
            throw new \LogicException('The email authentication code was not set');
        }

        return $this->authCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }
    public function setOtp(string $otp): static
    {
        $this->otp = $otp;

        return $this;
    }

    public function getOtp(): ?string
    {
        return $this->otp;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getImageProfil(): ?string
    {
        return $this->imageProfil;
    }

    public function setImageProfil(string $imageProfil): static
    {
        $this->imageProfil = $imageProfil;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }
  
    public function getResetToken()
    {
        return $this->reset_token;
    }


    public function setResetToken($reset_token): void
    {
        $this->reset_token = $reset_token;
    }
    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getActivated(): ?int
    {
        return $this->activated;
    }

    public function setActivated(int $activated): static
    {
        $this->activated = $activated;

        return $this;
    }

    public function getNiveauAcademique(): ?string
    {
        return $this->niveauAcademique;
    }

    public function setNiveauAcademique(string $niveauAcademique): static
    {
        $this->niveauAcademique = $niveauAcademique;

        return $this;
    }

    public function getDisponiblite(): ?int
    {
        return $this->disponiblite;
    }

    public function setDisponiblite(int $disponiblite): static
    {
        $this->disponiblite = $disponiblite;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getNiveauScolaire(): ?string
    {
        return $this->niveau_scolaire;
    }

    public function setNiveauScolaire(string $niveau_scolaire): static
    {
        $this->niveau_scolaire = $niveau_scolaire;

        return $this;
    }
    public function getUsername(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }
    
    public function getSalt()
    {
        // Vous n'avez pas besoin de sel avec des algorithmes de hachage modernes comme bcrypt
        return null;
    }

    public function eraseCredentials()
    {
        // Si vous stockez des données sensibles, effacez-les ici
    }
    public function setRoleFromChoice(string $roleChoice): self
    {
        // Map the selected role choice to the appropriate role value
        if ($roleChoice === 'Client') {
            $this->role = self::ROLE_CLIENT;
        } elseif ($roleChoice === 'Formateur') {
            $this->role = self::ROLE_FORMATEUR;
        }

        return $this;
    }
   
    
    
}

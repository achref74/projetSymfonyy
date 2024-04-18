<?php

namespace App\Entity;
use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; // Use the correct namespace


/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponseRepository")
 */
#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_reponse",type: "integer")]
    private  $id;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "idUser")]
    private  $user;
    
    // ...
    
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(?User $user): self
    {
        $this->user = $user;
    
        return $this;
    }


    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Description must not be blank")]

    private  $description;

    /**
     * @ORM\Column(type="datetime")
     */
    #[ORM\Column(type: "datetime")]
    private  $dateReponse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reclamation")
     * @ORM\JoinColumn(nullable=false)
     */
   
    #[ORM\OneToOne(targetEntity: Reclamation::class)]
    #[ORM\JoinColumn(name: "id_reclamation", referencedColumnName: "id_reclamation")]
    private  $reclamation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateReponse(): ?\DateTimeInterface
    {
        return $this->dateReponse;
    }

    public function setDateReponse(\DateTimeInterface $dateReponse): self
    {
        $this->dateReponse = $dateReponse;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}

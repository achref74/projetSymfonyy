<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
class Achat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idAchat")]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "The total amount must be provided.")]
    #[Assert\Positive(message: "The total amount must be a positive number.")]
    private ?float $total = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "The date must be provided.")]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $date = null;

  //  #[ORM\ManyToOne(inversedBy: 'achats')]
    #[ORM\JoinColumn(name: "idOutil", referencedColumnName: "id")]
    #[Assert\NotNull(message: "The associated tool must be provided.")]
    private ?Outil $outil = null;

    
   
    #[ORM\JoinColumn(name: "idFormation", referencedColumnName: "idFormation")]
    #[Assert\NotNull(message: "The associated tool must be provided.")]
    private ?Formation $Formation = null;
    
    #[ORM\ManyToOne(targetEntity: User::class)] // Spécifiez targetEntity pour la relation ManyToOne
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser", nullable: false, columnDefinition: "integer")]

    private ?User $iduser = null; 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOutil(): ?outil
    {
        return $this->outil;
    }

    public function setOutil(?outil $outil): self
    {
        $this->outil = $outil;

        return $this;
    }
    public function getFormation(): ?Formation
    {
        return $this->Formation;
    }

    public function setFormation(?Formation $Formation): self
    {
        $this->Formation = $Formation;

        return $this;
    }
    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

}

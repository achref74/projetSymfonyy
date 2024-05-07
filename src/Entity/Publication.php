<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuthorRepository;
use App\Repository\PublicationRepository;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"idP",type:"integer")]
    private ?int $idp= null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)] 
    private ?\DateTimeInterface $datecreation = null;

    #[ORM\Column(length: 255)]
    private ?string $contenup=null;

    #[ORM\Column(length: 255)]
    private ?string $image=null;

    #[ORM\Column]
    private ?int $nblike=null;

    
    #[ORM\ManyToOne(targetEntity: Forum::class)] // Spécifiez targetEntity pour la relation ManyToOne
    #[ORM\JoinColumn(name: "idForum", referencedColumnName: "idForum", nullable: false)]
    private ?Forum $idforum=null;

    #[ORM\ManyToOne(targetEntity: User::class)] // Spécifiez targetEntity pour la relation ManyToOne
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser", nullable: false)]
    private ?User $iduser = null;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): static
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getContenup(): ?string
    {
        return $this->contenup;
    }

    public function setContenup(?string $contenup): static
    {
        $this->contenup = $contenup;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getNblike(): ?int
    {
        return $this->nblike;
    }

    public function setNblike(?int $nblike): static
    {
        $this->nblike = $nblike;

        return $this;
    }

    public function getIdforum(): ?Forum
    {
        return $this->idforum;
    }

    public function setIdforum(?Forum $idforum): static
    {
        $this->idforum = $idforum;

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

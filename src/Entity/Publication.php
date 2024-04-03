<?php

namespace App\Entity;
use App\Repository\PublicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="publication")
 * @ORM\Entity
 */

#[ORM\Entity(repositoryClass: PublicationRepository::class)]

class Publication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="idP", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idP", type: "integer")]
    private  $idp;

    /**
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    #[ORM\Column(name: "dateCreation", type: "datetime")]
    private  $datecreation;

    /**
     * @ORM\Column(name="contenuP", type="text", length=65535, nullable=true)
     */
    #[ORM\Column(name: "contenuP", type: "text", length: 65535, nullable: true)]
    private  $contenup;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "image", type: "string", length: 255, nullable: true)]
    private  $image;

    /**
     * @ORM\Column(name="nbLike", type="integer", nullable=true)
     */
    #[ORM\Column(name: "nbLike", type: "integer", nullable: true)]
    private  $nblike;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Forum")
     * @ORM\JoinColumn(name="idForum", referencedColumnName="idForum")
     */
    #[ORM\ManyToOne(targetEntity: Forum::class)]
    #[ORM\JoinColumn(name: "idForum", referencedColumnName: "idForum")]
    private  $idforum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
    private  $iduser;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getContenup(): ?string
    {
        return $this->contenup;
    }

    public function setContenup(?string $contenup): self
    {
        $this->contenup = $contenup;

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

    public function getNblike(): ?int
    {
        return $this->nblike;
    }

    public function setNblike(?int $nblike): self
    {
        $this->nblike = $nblike;

        return $this;
    }

    public function getIdforum(): ?Forum
    {
        return $this->idforum;
    }

    public function setIdforum(?Forum $idforum): self
    {
        $this->idforum = $idforum;

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
}

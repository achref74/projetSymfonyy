<?php

namespace App\Entity;
use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
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
     * @ORM\Column(type="datetime")
     */
    #[ORM\Column(type: "datetime")]
    private  $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private  $contenu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[ORM\Column(type: "integer", nullable: true)]
    private  $rating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false, name="idUser", referencedColumnName="idUser")
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, name: "idUser", referencedColumnName: "idUser")]
    private  $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Publication")
     * @ORM\JoinColumn(nullable=false, name="idP", referencedColumnName="idP")
     */
    #[ORM\ManyToOne(targetEntity: Publication::class)]
    #[ORM\JoinColumn(nullable: false, name: "idP", referencedColumnName: "idP")]
    private  $publication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

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

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;

        return $this;
    }
}

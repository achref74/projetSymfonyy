<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idForum", columns={"idForum"})})
 * @ORM\Entity(repositoryClass=App\Repository\PublicationRepository::class)
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
     */
    private $datecreation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contenuP", type="text", length=65535, nullable=true)
     */
    private $contenup;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbLike", type="integer", nullable=true)
     */
    private $nblike;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

    /**
     * @var \Forum
     *
     * @ORM\ManyToOne(targetEntity="Forum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idForum", referencedColumnName="idForum")
     * })
     */
    private $idforum;

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

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): static
    {
        $this->iduser = $iduser;

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


}

<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Certificat
 *
 * @ORM\Table(name="certificat", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idFormation", columns={"idFormation"})})
 * @ORM\Entity
 */
class Certificat
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCertificat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcertificat;

    /**
     * @var int
     *
     * @ORM\Column(name="titre", type="integer", nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateObtention", type="date", nullable=false)
     */
    private $dateobtention;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrCours", type="integer", nullable=false)
     */
    private $nbrcours;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idFormation", referencedColumnName="idFormation")
     * })
     */
    private $idformation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

    public function getIdcertificat(): ?int
    {
        return $this->idcertificat;
    }

    public function getTitre(): ?int
    {
        return $this->titre;
    }

    public function setTitre(int $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateobtention(): ?\DateTimeInterface
    {
        return $this->dateobtention;
    }

    public function setDateobtention(\DateTimeInterface $dateobtention): static
    {
        $this->dateobtention = $dateobtention;

        return $this;
    }

    public function getNbrcours(): ?int
    {
        return $this->nbrcours;
    }

    public function setNbrcours(int $nbrcours): static
    {
        $this->nbrcours = $nbrcours;

        return $this;
    }

    public function getIdformation(): ?Formation
    {
        return $this->idformation;
    }

    public function setIdformation(?Formation $idformation): static
    {
        $this->idformation = $idformation;

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

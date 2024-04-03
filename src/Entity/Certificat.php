<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table(name="certificat", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="idFormation", columns={"idFormation"})})
 * @ORM\Entity(repositoryClass=App\Repository\CertificatRepository::class)
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
    private $idCertificat;


    #[ORM\Column(name: "titre", type: "string", length: 255, nullable: false)]
    private string $titre;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: false)]
    private string $description;

    #[ORM\Column(name: "dateObtention", type: "date", nullable: false)]
    private \DateTimeInterface $dateObtention;

    #[ORM\Column(name: "nbrCours", type: "integer", nullable: false)]
    private int $nbrCours;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(name: "idFormation", referencedColumnName: "idFormation")]
    private ?Formation $formation;

    
    public function getIdcertificat(): ?int
    {
        return $this->idCertificat;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
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

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): static
    {
        $this->iduser = $iduser;

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


}

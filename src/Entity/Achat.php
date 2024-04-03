<?php

namespace App\Entity;
use App\Repository\AchatRepository;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AchatRepository")
 */
#[ORM\Entity(repositoryClass: AchatRepository::class)]
class Achat
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
     * @ORM\Column(type="float")
     */
    #[ORM\Column(type: "float")]
    private  $total;

    /**
     * @ORM\Column(type="date")
     */
    #[ORM\Column(type: "date")]
    private  $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Outil")
     * @ORM\JoinColumn(nullable=false, name="idOutil", referencedColumnName="idoutils")
     */
    #[ORM\ManyToOne(targetEntity: Outil::class)]
    #[ORM\JoinColumn(nullable: false, name: "idOutil", referencedColumnName: "idoutils")]
    private  $outil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(nullable=false, name="idFormation", referencedColumnName="idFormation")
     */
    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(nullable: false, name: "idFormation", referencedColumnName: "idFormation")]
    private  $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOutil(): ?Outil
    {
        return $this->outil;
    }

    public function setOutil(?Outil $outil): self
    {
        $this->outil = $outil;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
}

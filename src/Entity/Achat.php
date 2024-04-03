<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table(name="achat", indexes={@ORM\Index(name="idFormation", columns={"idFormation"}), @ORM\Index(name="idOutil", columns={"idOutil"})})
 * @ORM\Entity(repositoryClass=App\Repository\AchatRepository::class)
 */
class Achat
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAchat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idachat;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

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
     * @var \Outil
     *
     * @ORM\ManyToOne(targetEntity="Outil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOutil", referencedColumnName="idoutils")
     * })
     */
    private $idoutil;

    public function getIdachat(): ?int
    {
        return $this->idachat;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getIdoutil(): ?Outil
    {
        return $this->idoutil;
    }

    public function setIdoutil(?Outil $idoutil): static
    {
        $this->idoutil = $idoutil;

        return $this;
    }


}

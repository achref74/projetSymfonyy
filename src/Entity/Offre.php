<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table(name="Offre", indexes={@ORM\Index(name="idFormation", columns={"idFormation"})})
 * @ORM\Entity(repositoryClass=App\Repository\FormationRepository::class)
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="idOffre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */

    #[ORM\Column(name: "prixOffre", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $prixOffre;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: false)]
    private string $description;

    #[ORM\Column(name: "dateD", type: "date", nullable: false)]
    private \DateTimeInterface $dateD;

    #[ORM\Column(name: "dateF", type: "date", nullable: false)]
    private \DateTimeInterface $dateF;

    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(name: "idFormation", referencedColumnName: "idFormation")]
    private ?Formation $formation;

    public function getIdoffre(): ?int
    {
        return $this->idoffre;
    }

    public function getPrixoffre(): ?float
    {
        return $this->prixoffre;
    }

    public function setPrixoffre(float $prixoffre): static
    {
        $this->prixoffre = $prixoffre;

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

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(\DateTimeInterface $dated): static
    {
        $this->dated = $dated;

        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeInterface $datef): static
    {
        $this->datef = $datef;

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

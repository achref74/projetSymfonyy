<?php

namespace App\Entity;
use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="offre")
 * @ORM\Entity
 */

#[ORM\Entity(repositoryClass: OffreRepository::class)]

class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="idOffre", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idOffre", type: "integer")]
    private  $idOffre;

    /**
     * @ORM\Column(name="prixOffre", type="float", precision=10, scale=0)
     */
    #[ORM\Column(name: "prixOffre", type: "float", precision: 10, scale: 0)]
    private  $prixOffre;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    #[ORM\Column(name: "description", type: "string", length: 255)]
    private  $description;

    /**
     * @ORM\Column(name="dateD", type="date")
     */
    #[ORM\Column(name: "dateD", type: "date")]
    private  $dateD;

    /**
     * @ORM\Column(name="dateF", type="date")
     */
    #[ORM\Column(name: "dateF", type: "date")]
    private  $dateF;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(name="idFormation", referencedColumnName="idFormation")
     */
    #[ORM\ManyToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(name: "idFormation", referencedColumnName: "idFormation")]
    private  $formation;

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function getPrixOffre(): ?float
    {
        return $this->prixOffre;
    }

    public function setPrixOffre(float $prixOffre): self
    {
        $this->prixOffre = $prixOffre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(\DateTimeInterface $dateF): self
    {
        $this->dateF = $dateF;

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

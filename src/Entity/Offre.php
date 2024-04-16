<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="idOffre", type="integer", nullable=false)
     */
    private int $idOffre;

    /**
     * @var float
     *
     * @ORM\Column(name="prixOffre", type="float", nullable=false)
     */
    private float $prixOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private string $description;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="dateD", type="date", nullable=false)
     */
    private \DateTimeInterface $dateD;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="dateF", type="date", nullable=false)
     */
    private \DateTimeInterface $dateF;

    /**
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumn(name="idFormation", referencedColumnName="idFormation")
     */
    private ?Formation $formation;

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

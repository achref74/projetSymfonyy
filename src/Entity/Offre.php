<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private  $idOffre;

    /**
     * @var float
     * @Assert\NotBlank(message="The price is required")
     * @Assert\Type(type="numeric", message="The price must be a number")
     * @Assert\GreaterThanOrEqual(value=1, message="The price must be a positive number ")
     * @ORM\Column(name="prixOffre", type="float", nullable=false)
     */
    private  $prixOffre;

    /**
     * @var string
     * @Assert\NotBlank(message="The description is required")
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private  $description;

    /**
     * @var \DateTimeInterface
     * @Assert\NotBlank(message="The start date is required")
     * @Assert\GreaterThan("today", message="The start date must be in the future")
     * @ORM\Column(name="dateD", type="date", nullable=false)
     */
    private  $dateD;

    /**
     * @var \DateTimeInterface
     * @Assert\NotBlank(message="The end date is required")
     * @Assert\GreaterThan("today", message="The end date must be in the future")
     
     * @Assert\GreaterThan(propertyPath="dateD", message="The end date must be greater than the start date")
     * @ORM\Column(name="dateF", type="date", nullable=false)
     */
    private  $dateF;

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

    public function setPrixOffre(?float $prixOffre): self
    {
        $this->prixOffre = $prixOffre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(?\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(?\DateTimeInterface $dateF): self
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

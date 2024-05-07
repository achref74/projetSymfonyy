<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
class Achat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "The total amount must be provided.")]
    #[Assert\Positive(message: "The total amount must be a positive number.")]
    private ?float $total = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "The date must be provided.")]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'achats')]
    #[Assert\NotNull(message: "The associated tool must be provided.")]
    private ?Outil $outil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOutil(): ?outil
    {
        return $this->outil;
    }

    public function setOutil(?outil $outil): self
    {
        $this->outil = $outil;

        return $this;
    }
}

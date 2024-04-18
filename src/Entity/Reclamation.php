<?php
namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert; // Use the correct namespace

/**
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="App\Repository\ReclamationRepository")
 */
#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_reclamation", type: "integer")]
    private $id_reclamation;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank(message="Description must not be blank")
     * @Assert\Length(
     *     max=500,
     *     maxMessage="Description cannot be longer than {{ limit }} characters"
     * )
     */
    #[ORM\Column(type: "string", length: 500)]
    #[Assert\NotBlank(message: "Description must not be blank")]
    #[Assert\Length(
        max: 500,
        maxMessage: "Description cannot be longer than {{ limit }} characters"
    )]
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Date must not be blank")
     */
    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank(message: "Date must not be blank")]
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Formation")
     * @ORM\JoinColumn(name="id_formation", referencedColumnName="idFormation", nullable=false)
     * @Assert\NotNull(message="Formation must not be null")
     */
    #[ORM\OneToOne(targetEntity: Formation::class)]
    #[ORM\JoinColumn(name: "id_formation", referencedColumnName: "idFormation", nullable: false)]
    #[Assert\NotNull(message: "Formation must not be null")]
    private $formation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Outil")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Outil must not be null")
     */
    #[ORM\OneToOne(targetEntity: Outil::class)]
    #[ORM\JoinColumn(name: "id_outil", referencedColumnName: "idoutils")]
    #[Assert\NotNull(message: "Outil must not be null")]
    private $outil;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="User must not be null")
     */
    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "idUser")]
    #[Assert\NotNull(message: "User must not be null")]
    private $user;

    public function getId(): ?int
    {
        return $this->id_reclamation;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getOutil(): ?Outil
    {
        return $this->outil;
    }

    public function setOutil(?Outil $outil): self
    {
        $this->outil = $outil;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user =$user;

        return $this;
    }
}

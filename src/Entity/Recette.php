<?php
namespace App\Entity;
use DateTimeImmutable; 
use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
 
#[UniqueEntity('name')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min : 2, max :50)]
    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[Assert\LessThan(1440)]
    #[Assert\Positive()]
    #[ORM\Column(nullable: true)]
    private ?int $time = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(51)]
    #[Assert\Positive()] 
    private ?int $Nbpersonne = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(6)]
    #[Assert\Positive()] 
    private ?int $difficulty = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;
   
    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(1001)]
    #[Assert\Positive()]
    private ?float $prix = null;

    #[ORM\Column]
    private ?bool $IsFavorite = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $UpdatedAt = null;


    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    
    private Collection $IngredientsL;
    public function __construct()
    {
        $this->IngredientsL = new ArrayCollection();
        $this->CreatedAt = new DateTimeImmutable;
        $this->UpdatedAt = new DateTimeImmutable;

    }
    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
       $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getNbpersonne(): ?int
    {
        return $this->Nbpersonne;
    }

    public function setNbpersonne(?int $Nbpersonne): static
    {
        $this->Nbpersonne = $Nbpersonne;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): static
    {
        $this->difficulty = $difficulty;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
  

    public function isIsFavorite(): ?bool
    {
        return $this->IsFavorite;
    }

    public function setIsFavorite(bool $IsFavorite): static
    {
        $this->IsFavorite = $IsFavorite;

        return $this;
    }
 
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }
 
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredientsL(): Collection
    {
        return $this->IngredientsL;
    }
    public function __toString(): string
    {
        return $this->addIngredientsL;
    }

    public function addIngredientsL(Ingredient $ingredientsL): static
    {
        if (!$this->IngredientsL->contains($ingredientsL)) {
            $this->IngredientsL->add($ingredientsL);
        }

        return $this;
    }

    public function removeIngredientsL(Ingredient $ingredientsL): static
    {
        $this->IngredientsL->removeElement($ingredientsL);

        return $this;
    }
 
}

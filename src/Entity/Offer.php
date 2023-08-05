<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
/**
 * @SuppressWarnings(PHPMD)
 */
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner un titre à votre offre')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Merci de donner un titre à votre offre avec moins de 255 caractères'
    )]
    private ?string $title = null;

    #[Assert\NotBlank(message: 'Merci de donner une description à votre offre')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner une localisation à votre offre')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La localisation ne doit pas dépasser 255 caractères'
    )]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner un type de contrat à votre offre')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le type de contrat ne doit pas dépasser 255 caractères'
    )]
    private ?string $contractType = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner une plage de salariale à votre offre')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La plage salariale ne doit pas dépasser 255 caractères'
    )]
    private ?string $salaryRange = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Merci de donner l'expérience requise à votre offre")]
    private ?int $experienceReq = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner les compétences requises pour votre offre')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Les compétences requises ne doivent pas dépasser 255 caractères'
    )]
    private ?string $skillsReq = null;

    #[Assert\NotBlank(message: "Merci d'indiquer la date de publication de votre offre")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePosted = null;

    #[Assert\NotBlank(message: "Merci d'indiquer le nom de votre société")]
    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[Assert\NotBlank(message: "Merci d'indiquer le métier recherché")]
    #[ORM\ManyToOne(inversedBy: 'offers')]
    private ?Category $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'offer')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->company;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(string $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getSalaryRange(): ?string
    {
        return $this->salaryRange;
    }

    public function setSalaryRange(string $salaryRange): self
    {
        $this->salaryRange = $salaryRange;

        return $this;
    }

    public function getExperienceReq(): ?int
    {
        return $this->experienceReq;
    }

    public function setExperienceReq(int $experienceReq): self
    {
        $this->experienceReq = $experienceReq;

        return $this;
    }

    public function getSkillsReq(): ?string
    {
        return $this->skillsReq;
    }

    public function setSkillsReq(string $skillsReq): self
    {
        $this->skillsReq = $skillsReq;

        return $this;
    }

    public function getDatePosted(): ?\DateTimeInterface
    {
        return $this->datePosted;
    }

    public function setDatePosted(\DateTimeInterface $datePosted): self
    {
        $this->datePosted = $datePosted;

        return $this;
    }


    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addOffer($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeOffer($this);
        }

        return $this;
    }
}

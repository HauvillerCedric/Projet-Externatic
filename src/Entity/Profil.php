<?php
//@codingStandardsIgnoreFile
namespace App\Entity;

use DateTime;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Form\Type\VichFileType;


#[Assert\EnableAutoMapping]
#[ORM\Entity(repositoryClass: ProfilRepository::class)]
#[Vich\Uploadable]
/**
 * @SuppressWarnings(PHPMD)
 */
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner un nom à votre profil')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Merci de donner un nom à votre profil de moins de 255 caractères'
    )]

    private ?string $titleProfil = null;

    #[Assert\NotBlank(message: 'Merci de donner une description à votre profil')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionProfil = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de donner une localisation à votre profil')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La localisation ne doit pas dépasser 255 caractères'
    )]
    private ?string $locationProfil = null;

    #[ORM\Column]
    private ?int $experienceYear = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de rajouter vos expériences à votre profil')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Vos expériences ne doivent pas dépasser 255 caractères'
    )]
    private ?string $skills = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci d\'indiquer un niveau d\'étude à votre profil')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La niveau d\étude ne doit pas dépasser 255 caractères'
    )]
    private ?string $education = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de rajouter vos langues parlées à votre profil')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Merci d\'indiquer vos langues en moins de  255 caractères'
    )]
    private ?string $language = null;

    #[Assert\NotBlank(message: "Merci d'indiquer votre date de naissance à votre profil")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDay = null;

    #[ORM\Column]
    private ?int $mobility = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $document = null;

    #[Vich\UploadableField(mapping: 'document_file', fileNameProperty: 'document')]
    private ?File $documentFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $poster = null;

    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'poster')]
    #[Assert\File(
        maxSize: '7M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $posterFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?Datetime $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExperienceYear(): ?int
    {
        return $this->experienceYear;
    }

    public function setExperienceYear(int $experienceYear): self
    {
        $this->experienceYear = $experienceYear;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(\DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    public function getMobility(): ?int
    {
        return $this->mobility;
    }

    public function setMobility(int $mobility): self
    {
        $this->mobility = $mobility;

        return $this;
    }

    /**
     * Get the value of locationProfil
     */ 
    public function getLocationProfil(): ?string
    {
        return $this->locationProfil;
    }

    /**
     * Set the value of locationProfil
     *
     * @return  self
     */ 
    public function setLocationProfil(string $locationProfil): self
    {
        $this->locationProfil = $locationProfil;

        return $this;
    }

    /**
     * Get the value of titleProfil
     */ 
    public function getTitleProfil(): ?string
    {
        return $this->titleProfil;
    }

    /**
     * Set the value of titleProfil
     *
     * @return  self
     */ 
    public function setTitleProfil(string $titleProfil): self
    {
        $this->titleProfil = $titleProfil;

        return $this;
    }

    /**
     * Get the value of descriptionProfil
     */ 
    public function getDescriptionProfil(): ?string
    {
        return $this->descriptionProfil;
    }

    /**
     * Set the value of descriptionProfil
     *
     * @return  self
     */ 
    public function setDescriptionProfil(string $descriptionProfil): self
    {
        $this->descriptionProfil = $descriptionProfil;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): static
    {
        $this->document = $document;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

     /**
    * Set the value of updatedAt
    *
    * @param DateTime|null $updatedAt
    * @return self
    */
    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    /**
     * Get the value of posterFile
     */ 
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * Set the value of posterFile
     *
     * @return  self
     */ 
    public function setPosterFile(File $image = null): Profil
    {
        $this->posterFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    /**
     * Get the value of documentFile
     */ 
    public function getDocumentFile(): ?File
    {
       return $this->documentFile;
    }

    /**
     * Set the value of documentFile
     *
     * @return  self
     */ 
    public function setDocumentFile(File $image = null): Profil
    {
        $this->documentFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getAvatarUrl(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        if (strpos($this->avatar, '/') !== false) {
            return $this->avatar;
        }

        return sprintf('/uploads/avatars/%s', $this->avatar);
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
    
}


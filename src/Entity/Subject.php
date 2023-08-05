<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Mailer::class)]
    private Collection $mailers;

    public function __construct()
    {
        $this->mailers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Mailer>
     */
    public function getMailers(): Collection
    {
        return $this->mailers;
    }

    public function addMailer(Mailer $mailer): self
    {
        if (!$this->mailers->contains($mailer)) {
            $this->mailers->add($mailer);
            $mailer->setSubject($this);
        }

        return $this;
    }

    public function removeMailer(Mailer $mailer): self
    {
        if ($this->mailers->removeElement($mailer)) {
            // set the owning side to null (unless already changed)
            if ($mailer->getSubject() === $this) {
                $mailer->setSubject(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $cv = null;

    #[ORM\Column(length: 255)]
    private ?string $skills = null;

    #[ORM\ManyToOne(inversedBy: 'candidates')]
    private ?Stage $stage = null;

    /**
     * @var Collection<int, VerifiedCandidate>
     */
    #[ORM\OneToMany(targetEntity: VerifiedCandidate::class, mappedBy: 'candidate')]
    private Collection $verifiedCandidates;

    public function __construct()
    {
        $this->verifiedCandidates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }
    
    public function getSkills(): ?string
    {
        return $this->skills;
    }

    public function setSkills(string $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;

        return $this;
    }
    public function __toString()
    {
        return $this->getId().'-'.$this->getFirstName().$this->getLastName();
    }

    /**
     * @return Collection<int, VerifiedCandidate>
     */
    public function getVerifiedCandidates(): Collection
    {
        return $this->verifiedCandidates;
    }

    public function addVerifiedCandidate(VerifiedCandidate $verifiedCandidate): static
    {
        if (!$this->verifiedCandidates->contains($verifiedCandidate)) {
            $this->verifiedCandidates->add($verifiedCandidate);
            $verifiedCandidate->setCandidate($this);
        }

        return $this;
    }

    public function removeVerifiedCandidate(VerifiedCandidate $verifiedCandidate): static
    {
        if ($this->verifiedCandidates->removeElement($verifiedCandidate)) {
            // set the owning side to null (unless already changed)
            if ($verifiedCandidate->getCandidate() === $this) {
                $verifiedCandidate->setCandidate(null);
            }
        }

        return $this;
    }
}

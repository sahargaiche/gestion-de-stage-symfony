<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $skills = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSkills(): ?string
    {
        return $this->skills;
    }
    public function __toString()
    {
        return $this->getId().'-'.$this->gettype();
    }
    public function setSkills(string $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }    #[ORM\ManyToOne(inversedBy: 'stages')]
    private ?Candidate $candidate = null;

    /**
     * @var Collection<int, Candidate>
     */
    #[ORM\OneToMany(targetEntity: Candidate::class, mappedBy: 'stage')]
    private Collection $candidates;

    /**
     * @var Collection<int, VerifiedCandidate>
     */
    #[ORM\OneToMany(targetEntity: VerifiedCandidate::class, mappedBy: 'stage')]
    private Collection $verifiedCandidates;

    public function __construct()
    {
        $this->candidates = new ArrayCollection();
        $this->verifiedCandidates = new ArrayCollection();
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getCandidates(): Collection
    {
        return $this->candidates;
    }

    public function addCandidate(Candidate $candidate): static
    {
        if (!$this->candidates->contains($candidate)) {
            $this->candidates->add($candidate);
            $candidate->setStage($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): static
    {
        if ($this->candidates->removeElement($candidate)) {
            // set the owning side to null (unless already changed)
            if ($candidate->getStage() === $this) {
                $candidate->setStage(null);
            }
        }

        return $this;
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
            $verifiedCandidate->setStage($this);
        }

        return $this;
    }

    public function removeVerifiedCandidate(VerifiedCandidate $verifiedCandidate): static
    {
        if ($this->verifiedCandidates->removeElement($verifiedCandidate)) {
            // set the owning side to null (unless already changed)
            if ($verifiedCandidate->getStage() === $this) {
                $verifiedCandidate->setStage(null);
            }
        }

        return $this;
    }
}

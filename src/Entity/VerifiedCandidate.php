<?php

namespace App\Entity;

use App\Repository\VerifiedCandidateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VerifiedCandidateRepository::class)]
class VerifiedCandidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'verifiedCandidates')]
    private ?Candidate $candidate = null;

    #[ORM\Column(length: 255 ,options: ["default" =>'en attend' ])]
    private ?string $statut = 'en attend';

    #[ORM\ManyToOne(inversedBy: 'verifiedCandidates')]
    private ?Stage $stage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): static
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

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
}

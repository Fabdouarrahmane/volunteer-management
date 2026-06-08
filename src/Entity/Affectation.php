<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationRepository::class)]
class Affectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateAffectation = null;

    #[ORM\Column(length: 255)]
    private ?string $roleMission = null;

    #[ORM\Column(length: 50)]
    private ?string $statutAffectation = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Benevole $benevole = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAffectation(): ?\DateTime
    {
        return $this->dateAffectation;
    }

    public function setDateAffectation(\DateTime $dateAffectation): static
    {
        $this->dateAffectation = $dateAffectation;

        return $this;
    }

    public function getRoleMission(): ?string
    {
        return $this->roleMission;
    }

    public function setRoleMission(string $roleMission): static
    {
        $this->roleMission = $roleMission;

        return $this;
    }

    public function getStatutAffectation(): ?string
    {
        return $this->statutAffectation;
    }

    public function setStatutAffectation(string $statutAffectation): static
    {
        $this->statutAffectation = $statutAffectation;

        return $this;
    }

    public function getBenevole(): ?Benevole
    {
        return $this->benevole;
    }

    public function setBenevole(?Benevole $benevole): static
    {
        $this->benevole = $benevole;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }
}

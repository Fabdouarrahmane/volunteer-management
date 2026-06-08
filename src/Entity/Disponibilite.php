<?php

namespace App\Entity;

use App\Repository\DisponibiliteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
class Disponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDisponibilite = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $heureFin = null;

    #[ORM\Column(length: 50)]
    private ?string $statutDisponibilite = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Benevole $benevole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDisponibilite(): ?\DateTime
    {
        return $this->dateDisponibilite;
    }

    public function setDateDisponibilite(\DateTime $dateDisponibilite): static
    {
        $this->dateDisponibilite = $dateDisponibilite;

        return $this;
    }

    public function getHeureDebut(): ?\DateTime
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTime $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTime
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTime $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getStatutDisponibilite(): ?string
    {
        return $this->statutDisponibilite;
    }

    public function setStatutDisponibilite(string $statutDisponibilite): static
    {
        $this->statutDisponibilite = $statutDisponibilite;

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
}

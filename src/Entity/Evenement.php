<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $dateEvenement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu = null;

    #[ORM\Column]
    private ?int $nbBenevoles = null;

    #[ORM\Column(length: 50)]
    private ?string $statutEvenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateEvenement(): ?\DateTime
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(\DateTime $dateEvenement): static
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNbBenevoles(): ?int
    {
        return $this->nbBenevoles;
    }

    public function setNbBenevoles(int $nbBenevoles): static
    {
        $this->nbBenevoles = $nbBenevoles;

        return $this;
    }

    public function getStatutEvenement(): ?string
    {
        return $this->statutEvenement;
    }

    public function setStatutEvenement(string $statutEvenement): static
    {
        $this->statutEvenement = $statutEvenement;

        return $this;
    }
}

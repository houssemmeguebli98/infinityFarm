<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'ressource', indexes: [new ORM\Index(name: 'fk_idterrain', columns: ['idterrain'])])]
#[ORM\Entity]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'idRes', type: 'integer', nullable: false)]
    private int $idres;

    #[Assert\Choice(choices: ['plante', 'animaux'], message: "Le type de ressource doit être 'plante' ou 'animaux'.")]
    #[ORM\Column(name: 'typeRes', type: 'string', length: 255, nullable: false)]
    private string $typeres;

    #[Assert\Length(min: 3, minMessage: "La spécie doit avoir au moins {{ limit }} caractères.")]
    #[ORM\Column(name: 'speciesRes', type: 'string', length: 255, nullable: false)]
    private string $speciesres;

    #[Assert\GreaterThanOrEqual(value: 0, message: "La quantité doit être supérieure ou égale à 0.")]
    #[ORM\Column(name: 'quantiteRes', type: 'integer', nullable: false)]
    private int $quantiteres;

    #[ORM\ManyToOne(targetEntity: Terrain::class)]
    #[ORM\JoinColumn(name: 'idterrain', referencedColumnName: 'idTerrain')]
    private Terrain $idterrain;

    // Getters and setters...

    public function getIdres(): ?int
    {
        return $this->idres;
    }

    public function getTyperes(): ?string
    {
        return $this->typeres;
    }

    public function setTyperes(string $typeres): static
    {
        $this->typeres = $typeres;

        return $this;
    }

    public function getSpeciesres(): ?string
    {
        return $this->speciesres;
    }

    public function setSpeciesres(string $speciesres): static
    {
        $this->speciesres = $speciesres;

        return $this;
    }

    public function getQuantiteres(): ?int
    {
        return $this->quantiteres;
    }

    public function setQuantiteres(int $quantiteres): static
    {
        $this->quantiteres = $quantiteres;

        return $this;
    }

    public function getIdterrain(): ?Terrain
    {
        return $this->idterrain;
    }

    public function setIdterrain(?Terrain $idterrain): static
    {
        $this->idterrain = $idterrain;

        return $this;
    }
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'terrain')]
#[ORM\Entity]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'idTerrain', type: 'integer', nullable: false)]
    private int $idterrain;

    #[ORM\Column(name: 'nomTerrain', type: 'string', length: 255, nullable: false)]
    private string $nomterrain;

    #[ORM\Column(name: 'localisation', type: 'string', length: 255, nullable: false)]
    private string $localisation;

    #[ORM\Column(name: 'superficie', type: 'float', precision: 10, scale: 0, nullable: false)]
    private float $superficie;

    public function getIdterrain(): ?int
    {
        return $this->idterrain;
    }

    public function getNomterrain(): ?string
    {
        return $this->nomterrain;
    }

    public function setNomterrain(string $nomterrain): static
    {
        $this->nomterrain = $nomterrain;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }
}

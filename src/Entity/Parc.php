<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Table(name: "parc")]
#[Entity]
class Parc
{
    #[Id]
    #[Column(name: "idparc", type: "integer", nullable: false)]
    #[GeneratedValue(strategy: "IDENTITY")]
    private int $idparc;

    #[Column(name: "nomparc", type: "string", length: 255, nullable: false)]
    private string $nomparc;

    #[Column(name: "adresseParc", type: "string", length: 255, nullable: false)]
    private string $adresseparc;

    #[Column(name: "superficieParc", type: "float", precision: 10, scale: 0, nullable: false)]
    private float $superficieparc;




    /**
     * @return int
     */
    public function getIdparc(): int
    {
        return $this->idparc;
    }

    /**
     * @return string
     */
    public function getNomparc(): string
    {
        return $this->nomparc;
    }

    /**
     * @return string
     */
    public function getAdresseparc(): string
    {
        return $this->adresseparc;
    }

    /**
     * @return float
     */
    public function getSuperficieparc(): float
    {
        return $this->superficieparc;
    }

    /**
     * @param int $idparc
     */
    public function setIdparc(int $idparc): void
    {
        $this->idparc = $idparc;
    }

    /**
     * @param string $nomparc
     */
    public function setNomparc(string $nomparc): void
    {
        $this->nomparc = $nomparc;
    }

    /**
     * @param string $adresseparc
     */
    public function setAdresseparc(string $adresseparc): void
    {
        $this->adresseparc = $adresseparc;
    }

    /**
     * @param float $superficieparc
     */
    public function setSuperficieparc(float $superficieparc): void
    {
        $this->superficieparc = $superficieparc;
    }



}
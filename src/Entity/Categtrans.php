<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Categtrans
{
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $idCatTra;

    #[ORM\Column(length: 150)]

    private ?string $nomCatTra = null;

    #[ORM\Column(length: 250)]
    private ?string $descripCatTra = null;
    

    public function getIdCatTra(): ?int
    {
        return $this->idCatTra;
    }

    public function getNomCatTra(): ?string
    {
        return $this->nomCatTra;
    }

    public function setNomCatTra(string $nomCatTra): static
    {
        $this->nomCatTra = $nomCatTra;

        return $this;
    }

    public function getDescripCatTra(): ?string
    {
        return $this->descripCatTra;
    }

    public function setDescripCatTra(string $descripCatTra): static
    {
        $this->descripCatTra = $descripCatTra;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categtrans
 *
 * @ORM\Table(name="categtrans")
 * @ORM\Entity
 */
class Categtrans
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cat_tra", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCatTra;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_cat_tra", type="string", length=255, nullable=false)
     */
    private $nomCatTra;

    /**
     * @var string
     *
     * @ORM\Column(name="descrip_cat_tra", type="string", length=255, nullable=false)
     */
    private $descripCatTra;

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

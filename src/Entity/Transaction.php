<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tra", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTra;

    /**
     * @var string
     *
     * @ORM\Column(name="categ_tra", type="string", length=255, nullable=false)
     */
    private $categTra;

    /**
     * @var string
     *
     * @ORM\Column(name="type_tra", type="string", length=255, nullable=false)
     */
    private $typeTra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_tra", type="date", nullable=false)
     */
    private $dateTra;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    public function getIdTra(): ?int
    {
        return $this->idTra;
    }

    public function getCategTra(): ?string
    {
        return $this->categTra;
    }

    public function setCategTra(string $categTra): static
    {
        $this->categTra = $categTra;

        return $this;
    }

    public function getTypeTra(): ?string
    {
        return $this->typeTra;
    }

    public function setTypeTra(string $typeTra): static
    {
        $this->typeTra = $typeTra;

        return $this;
    }

    public function getDateTra(): ?\DateTimeInterface
    {
        return $this->dateTra;
    }

    public function setDateTra(\DateTimeInterface $dateTra): static
    {
        $this->dateTra = $dateTra;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }


}

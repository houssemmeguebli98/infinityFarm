<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'activite')]
#[ORM\Entity]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'idAct', type: 'integer', nullable: false)]
    private int $idact;

    #[ORM\Column(name: 'objetAct', type: 'string', length: 255, nullable: false)]
    private string $objetact;

    #[ORM\Column(name: 'descriptionAct', type: 'string', length: 255, nullable: false)]
    private string $descriptionact;

    #[ORM\Column(name: 'distAct', type: 'string', length: 255, nullable: false)]
    private string $distact;

    #[ORM\Column(name: 'emailDist', type: 'string', length: 255, nullable: false)]
    private string $emaildist;

    #[ORM\Column(name: 'speciesRES', type: 'string', length: 255, nullable: false)]
    private string $speciesres;

    #[ORM\Column(name: 'etatAct', type: 'string', length: 255, nullable: false)]
    private string $etatact;

    public function getIdact(): ?int
    {
        return $this->idact;
    }

    public function getObjetact(): ?string
    {
        return $this->objetact;
    }

    public function setObjetact(string $objetact): static
    {
        $this->objetact = $objetact;

        return $this;
    }

    public function getDescriptionact(): ?string
    {
        return $this->descriptionact;
    }

    public function setDescriptionact(string $descriptionact): static
    {
        $this->descriptionact = $descriptionact;

        return $this;
    }

    public function getDistact(): ?string
    {
        return $this->distact;
    }

    public function setDistact(string $distact): static
    {
        $this->distact = $distact;

        return $this;
    }

    public function getEmaildist(): ?string
    {
        return $this->emaildist;
    }

    public function setEmaildist(string $emaildist): static
    {
        $this->emaildist = $emaildist;

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

    public function getEtatact(): ?string
    {
        return $this->etatact;
    }

    public function setEtatact(string $etatact): static
    {
        $this->etatact = $etatact;

        return $this;
    }
}

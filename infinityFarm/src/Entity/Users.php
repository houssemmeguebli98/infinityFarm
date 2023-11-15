<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'users')]
#[ORM\Entity]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private ?int $id;

    #[ORM\Column(name: "nom", type: "string", length: 255, nullable: true)]
    private ?string $nom;

    #[ORM\Column(name: "prenom", type: "string", length: 255, nullable: true)]
    private ?string $prenom;

    #[ORM\Column(name: "mail", type: "string", length: 255, nullable: true)]
    private ?string $mail;

    #[ORM\Column(name: "numeroTelephone", type: "string", length: 20, nullable: true)]
    private ?string $numerotelephone;

    #[ORM\Column(name: "role", type: "string", length: 255, nullable: true)]
    private ?string $role;

    #[ORM\Column(name: "motDePasse", type: "string", length: 255, nullable: true)]
    private ?string $motdepasse;

    #[ORM\Column(name: "ville", type: "string", length: 100, nullable: true)]
    private ?string $ville;

    #[ORM\Column(name: "sexe", type: "string", length: 10, nullable: true)]
    private ?string $sexe;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNumerotelephone(): ?string
    {
        return $this->numerotelephone;
    }

    public function setNumerotelephone(?string $numerotelephone): static
    {
        $this->numerotelephone = $numerotelephone;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(?string $motdepasse): static
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }


}

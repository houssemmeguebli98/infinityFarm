<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="messages", indexes={@ORM\Index(name="source", columns={"source"}), @ORM\Index(name="destinataire", columns={"destinataire"})})
 * @ORM\Entity
 */
class Messages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

     /**
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="destinataire", referencedColumnName="id")
     */
    private $destinataire;

    /**
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="source", referencedColumnName="id")
     */
    private $source;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getDestinataire(): ?Users
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Users $destinataire): self
    {
        $this->destinataire = $destinataire;
        return $this;
    }

    public function getSource(): ?Users
    {
        return $this->source;
    }

    public function setSource(?Users $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }


}

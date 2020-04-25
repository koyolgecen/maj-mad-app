<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CaracteristiqueNatureRepository")
 */
class CaracteristiqueNature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $descCaracNature;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $nomCaracNature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nature", inversedBy="caracteristiquesNature")
     */
    private $natures;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomCaracNature;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescCaracNature(): ?string
    {
        return $this->descCaracNature;
    }

    public function setDescCaracNature(string $descCaracNature): self
    {
        $this->descCaracNature = $descCaracNature;

        return $this;
    }

    public function getNomCaracNature(): ?string
    {
        return $this->nomCaracNature;
    }

    public function setNomCaracNature(string $nomCaracNature): self
    {
        $this->nomCaracNature = $nomCaracNature;

        return $this;
    }

    public function getNatures(): ?Nature
    {
        return $this->natures;
    }

    public function setNatures(?Nature $natures): self
    {
        $this->natures = $natures;

        return $this;
    }
}

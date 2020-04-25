<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniteNatureRepository")
 */
class UniteNature
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
    private $descUniteNature;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $uniteUsageNature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Nature", inversedBy="unitesNature")
     */
    private $natures;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descUniteNature;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescUniteNature(): ?string
    {
        return $this->descUniteNature;
    }

    public function setDescUniteNature(string $descUniteNature): self
    {
        $this->descUniteNature = $descUniteNature;

        return $this;
    }

    public function getUniteUsageNature(): ?string
    {
        return $this->uniteUsageNature;
    }

    public function setUniteUsageNature(string $uniteUsageNature): self
    {
        $this->uniteUsageNature = $uniteUsageNature;

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

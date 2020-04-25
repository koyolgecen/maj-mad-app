<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureRepository")
 */
class Nature
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
    private $nomNature;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CaracteristiqueNature", mappedBy="natures")
     */
    private $caracteristiquesNature;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UniteNature", mappedBy="natures")
     */
    private $unitesNature;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomNature;
    }

    public function __construct()
    {
        $this->caracteristiquesNature = new ArrayCollection();
        $this->unitesNature = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomNature(): ?string
    {
        return $this->nomNature;
    }

    public function setNomNature(string $nomNature): self
    {
        $this->nomNature = $nomNature;

        return $this;
    }

    /**
     * @return Collection|CaracteristiqueNature[]
     */
    public function getCaracteristiquesNature(): Collection
    {
        return $this->caracteristiquesNature;
    }

    public function addCaracteristiquesNature(CaracteristiqueNature $caracteristiquesNature): self
    {
        if (!$this->caracteristiquesNature->contains($caracteristiquesNature)) {
            $this->caracteristiquesNature[] = $caracteristiquesNature;
            $caracteristiquesNature->setNatures($this);
        }

        return $this;
    }

    public function removeCaracteristiquesNature(CaracteristiqueNature $caracteristiquesNature): self
    {
        if ($this->caracteristiquesNature->contains($caracteristiquesNature)) {
            $this->caracteristiquesNature->removeElement($caracteristiquesNature);
            // set the owning side to null (unless already changed)
            if ($caracteristiquesNature->getNatures() === $this) {
                $caracteristiquesNature->setNatures(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UniteNature[]
     */
    public function getUnitesNature(): Collection
    {
        return $this->unitesNature;
    }

    public function addUnitesNature(UniteNature $unitesNature): self
    {
        if (!$this->unitesNature->contains($unitesNature)) {
            $this->unitesNature[] = $unitesNature;
            $unitesNature->setNatures($this);
        }

        return $this;
    }

    public function removeUnitesNature(UniteNature $unitesNature): self
    {
        if ($this->unitesNature->contains($unitesNature)) {
            $this->unitesNature->removeElement($unitesNature);
            // set the owning side to null (unless already changed)
            if ($unitesNature->getNatures() === $this) {
                $unitesNature->setNatures(null);
            }
        }

        return $this;
    }
}

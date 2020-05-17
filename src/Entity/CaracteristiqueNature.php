<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CaracteristiqueNatureRepository")
 *
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
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
    private $nomCaracNature;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $descCaracNature;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nature", mappedBy="caracteristiqueNature")
     */
    private $natures;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomCaracNature;
    }

    /**
     * CaracteristiqueNature constructor.
     */
    public function __construct()
    {
        $this->natures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescCaracNature(): ?string
    {
        return $this->descCaracNature;
    }

    public function setDescCaracNature(string $descCaracNature): self
    {
        $this->descCaracNature = $descCaracNature;

        return $this;
    }

    /**
     * @return Collection|Nature[]
     */
    public function getNatures(): ?Collection
    {
        return $this->natures;
    }

    public function addNature(Nature $nature): self
    {
        if (!$this->natures->contains($nature)) {
            $this->natures[] = $nature;
            $nature->setCaracteristiqueNature($this);
        }

        return $this;
    }

    public function removeNature(Nature $nature): self
    {
        if ($this->natures->contains($nature)) {
            $this->natures->removeElement($nature);
            // set the owning side to null (unless already changed)
            if ($nature->getCaracteristiqueNature() === $this) {
                $nature->setCaracteristiqueNature(null);
            }
        }

        return $this;
    }
}

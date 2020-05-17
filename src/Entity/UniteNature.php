<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniteNatureRepository")
 *
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
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
    private $uniteUsageNature;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $descUniteNature;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nature", mappedBy="uniteNature")
     */
    private $natures;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->uniteUsageNature;
    }

    /**
     * UniteNature constructor.
     */
    public function __construct()
    {
        $this->natures = new ArrayCollection();
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
            $nature->setUniteNature($this);
        }

        return $this;
    }

    public function removeNature(Nature $nature): self
    {
        if ($this->natures->contains($nature)) {
            $this->natures->removeElement($nature);
            // set the owning side to null (unless already changed)
            if ($nature->getUniteNature() === $this) {
                $nature->setUniteNature(null);
            }
        }

        return $this;
    }
}

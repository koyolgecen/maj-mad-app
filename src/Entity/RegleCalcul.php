<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegleCalculRepository")
 *
 * @author Clément COURTET <clement.courtet@viacesi.fr>
 */
class RegleCalcul
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string" , length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $calcul;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeConception", mappedBy="regleCalcul")
     */
    private $modeConceptions;

    public function __toString()
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->modeConceptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalcul(): ?float
    {
        return $this->calcul;
    }

    public function setCalcul(float $calcul): self
    {
        $this->calcul = $calcul;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|ModeConception[]
     */
    public function getModeConceptions(): Collection
    {
        return $this->modeConceptions;
    }

    public function addModeConception(ModeConception $modeConception): self
    {
        if (!$this->modeConceptions->contains($modeConception)) {
            $this->modeConceptions[] = $modeConception;
            $modeConception->setRegleCalcul($this);
        }

        return $this;
    }

    public function removeModeConception(ModeConception $modeConception): self
    {
        if ($this->modeConceptions->contains($modeConception)) {
            $this->modeConceptions->removeElement($modeConception);
            // set the owning side to null (unless already changed)
            if ($modeConception->getRegleCalcul() === $this) {
                $modeConception->setRegleCalcul(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MargeRepository")
 */
class Marge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $MargeEntreprise;

    /**
     * @ORM\Column(type="float")
     */
    private $MargeCommerciale;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Composant", mappedBy="marge")
     */
    private $composants;

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO mithat change nom
        return (string) $this->id;
    }

    public function __construct()
    {
        $this->composants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMargeEntreprise(): ?float
    {
        return $this->MargeEntreprise;
    }

    public function setMargeEntreprise(float $MargeEntreprise): self
    {
        $this->MargeEntreprise = $MargeEntreprise;

        return $this;
    }

    public function getMargeCommerciale(): ?float
    {
        return $this->MargeCommerciale;
    }

    public function setMargeCommerciale(float $MargeCommerciale): self
    {
        $this->MargeCommerciale = $MargeCommerciale;

        return $this;
    }

    /**
     * @return Collection|Composant[]
     */
    public function getComposants(): Collection
    {
        return $this->composants;
    }

    public function addComposant(Composant $composant): self
    {
        if (!$this->composants->contains($composant)) {
            $this->composants[] = $composant;
            $composant->setMarge($this);
        }

        return $this;
    }

    public function removeComposant(Composant $composant): self
    {
        if ($this->composants->contains($composant)) {
            $this->composants->removeElement($composant);
            // set the owning side to null (unless already changed)
            if ($composant->getMarge() === $this) {
                $composant->setMarge(null);
            }
        }

        return $this;
    }
}
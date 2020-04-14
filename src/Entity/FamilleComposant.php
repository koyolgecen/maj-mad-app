<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilleComposantRepository")
 */
class FamilleComposant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomComposant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Composant", mappedBy="famille")
     */
    private $composants;

    public function __toString()
    {
       return $this->nomComposant;
    }

    public function __construct()
    {
        $this->composants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComposant(): ?string
    {
        return $this->nomComposant;
    }

    public function setNomComposant(string $nomComposant): self
    {
        $this->nomComposant = $nomComposant;

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
            $composant->setFamille($this);
        }

        return $this;
    }

    public function removeComposant(Composant $composant): self
    {
        if ($this->composants->contains($composant)) {
            $this->composants->removeElement($composant);
            // set the owning side to null (unless already changed)
            if ($composant->getFamille() === $this) {
                $composant->setFamille(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MargeRepository")
 *
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
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
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    private $MargeEntreprise;

    /**
     * @ORM\Column(type="float", scale=2)
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
        return (string) $this->nom;
    }

    public function __construct()
    {
        $this->composants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoupeDePrincipeRepository")
 */
class CoupeDePrincipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $typeCoupePrincipe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Module", mappedBy="coupeDePrincipe_id")
     */
    private $modules;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    public function __toString()
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCoupePrincipe(): ?string
    {
        return $this->typeCoupePrincipe;
    }

    public function setTypeCoupePrincipe(string $typeCoupePrincipe): self
    {
        $this->typeCoupePrincipe = $typeCoupePrincipe;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setCoupeDePrincipeId($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getCoupeDePrincipeId() === $this) {
                $module->setCoupeDePrincipeId(null);
            }
        }

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
}

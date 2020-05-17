<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeleARealiserRepository")
 *
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 */
class ModeleARealiser
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="modeles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $projet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModuleARealiser", mappedBy="modele")
     */
    private $modules;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection|ModuleARealiser[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(ModuleARealiser $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setModele($this);
        }

        return $this;
    }

    public function removeModule(ModuleARealiser $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getModele() === $this) {
                $module->setModele(null);
            }
        }

        return $this;
    }
}

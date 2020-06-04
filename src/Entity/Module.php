<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 *
 * @author Clément COURTET <clement.courtet@viacesi.fr>
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class Module
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
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CoupeDePrincipe", inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coupeDePrincipe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CCTP", inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cctp;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Composant")
     */
    private $moduleComposant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Modele", mappedBy="modules")
     */
    private $modeles;

    /**
     * Module constructor.
     */
    public function __construct()
    {
        $this->moduleComposant = new ArrayCollection();
        $this->modeles = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * @return string
     */
    public function getCoupeDePrincipe()
    {
        return $this->coupeDePrincipe;
    }

    /**
     * @param $coupeDePrincipe
     */
    public function setCoupeDePrincipe($coupeDePrincipe): void
    {
        $this->coupeDePrincipe = $coupeDePrincipe;
    }

    /**
     * @return string
     */
    public function getCctp()
    {
        return $this->cctp;
    }

    /**
     * @param $cctp
     */
    public function setCctp($cctp): void
    {
        $this->cctp = $cctp;
    }

    /**
     * @return Collection|Composant[]
     */
    public function getModuleComposant(): Collection
    {
        return $this->moduleComposant;
    }

    public function addModuleComposant(Composant $moduleComposant): self
    {
        if (!$this->moduleComposant->contains($moduleComposant)) {
            $this->moduleComposant[] = $moduleComposant;
        }

        return $this;
    }

    public function removeModuleComposant(Composant $module_composant): self
    {
        if ($this->moduleComposant->contains($module_composant)) {
            $this->moduleComposant->removeElement($module_composant);
        }

        return $this;
    }

    /**
     * @return Collection|Modele[]
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    public function addModele(Modele $modele): self
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles[] = $modele;
            $modele->addModule($this);
        }

        return $this;
    }

    public function removeModele(Modele $modele): self
    {
        if ($this->modeles->contains($modele)) {
            $this->modeles->removeElement($modele);
            $modele->removeModule($this);
        }

        return $this;
    }
}

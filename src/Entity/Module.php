<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
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
     * @ORM\Column(name="coupeDePrincipe_id")
     */
    private $coupeDePrincipe_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CCTP")
     * @ORM\Column(name="cctp_id")
     */
    private $cctp_id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Composant")
     */
    private $moduleComposant;

    public function __construct()
    {
        $this->moduleComposant = new ArrayCollection();
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

    public function getCoupeDePrincipeId(): string
    {
        return $this->coupeDePrincipe_id;
    }

    public function setCoupeDePrincipeId(?CoupeDePrincipe $coupeDePrincipe_id): self
    {
        $this->coupeDePrincipe_id = $coupeDePrincipe_id;

        return $this;
    }

    public function getCctpId(): string
    {
        return $this->cctp_id;
    }

    public function setCctpId(?CCTP $cctp_id): self
    {
        $this->cctp_id = $cctp_id;

        return $this;
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
}

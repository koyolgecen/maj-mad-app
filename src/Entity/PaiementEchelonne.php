<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaiementEchelonneRepository")
 */
class PaiementEchelonne
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
    private $nomEtape;

    /**
     * @ORM\Column(type="float")
     */
    private $pourcentageAPayer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="paiementEchelonne")
     */
    private $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->nomEtape . ' - ' . $this->pourcentageAPayer * 100 . '%';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEtape(): ?string
    {
        return $this->nomEtape;
    }

    public function setNomEtape(string $nomEtape): self
    {
        $this->nomEtape = $nomEtape;

        return $this;
    }

    public function getPourcentageAPayer(): ?float
    {
        return $this->pourcentageAPayer;
    }

    public function setPourcentageAPayer(float $pourcentageAPayer): self
    {
        $this->pourcentageAPayer = $pourcentageAPayer;

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->setPaiementEchelonne($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->contains($devi)) {
            $this->devis->removeElement($devi);
            // set the owning side to null (unless already changed)
            if ($devi->getPaiementEchelonne() === $this) {
                $devi->setPaiementEchelonne(null);
            }
        }

        return $this;
    }
}

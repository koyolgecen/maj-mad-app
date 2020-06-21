<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GammeRepository")
 *
 * @author Clément COURTET <clement.courtet@viacesi.fr>
 */
class Gamme
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
     * @ORM\ManyToOne(targetEntity="App\Entity\IsolantGamme", inversedBy="gammes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isolant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CouvertureGamme", inversedBy="gammes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $couverture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QualiteHuisserieGamme", inversedBy="gammes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $qualitehuisserie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FinitionExterieurGamme", inversedBy="gammes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $finitionExterieur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeConception", inversedBy="gammes")
     */
    private $modeConception;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="gamme")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modele", inversedBy="gammes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    public function __toString()
    {
        return $this->nom;
    }

    public function __construct()
    {
        $this->produits = new ArrayCollection();
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

    public function getIsolant(): ?IsolantGamme
    {
        return $this->isolant;
    }

    public function setIsolant(?IsolantGamme $isolant): self
    {
        $this->isolant = $isolant;

        return $this;
    }

    public function getCouverture(): ?CouvertureGamme
    {
        return $this->couverture;
    }

    public function setCouverture(?CouvertureGamme $couverture): self
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getQualitehuisserie(): ?QualiteHuisserieGamme
    {
        return $this->qualitehuisserie;
    }

    public function setQualitehuisserie(?QualiteHuisserieGamme $qualitehuisserie): self
    {
        $this->qualitehuisserie = $qualitehuisserie;

        return $this;
    }

    public function getFinitionExterieur(): ?FinitionExterieurGamme
    {
        return $this->finitionExterieur;
    }

    public function setFinitionExterieur(?FinitionExterieurGamme $finitionExterieur): self
    {
        $this->finitionExterieur = $finitionExterieur;

        return $this;
    }

    public function getModeConception(): ?ModeConception
    {
        return $this->modeConception;
    }

    public function setModeConception(?ModeConception $modeConception): self
    {
        $this->modeConception = $modeConception;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setGamme($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            // set the owning side to null (unless already changed)
            if ($produit->getGamme() === $this) {
                $produit->setGamme(null);
            }
        }

        return $this;
    }

    /**
     * @return Modele|null
     */
    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }
}

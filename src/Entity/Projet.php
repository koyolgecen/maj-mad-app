<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 *
 * @author Clément COURTET <clement.courtet@viacesi.fr>
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 */
class Projet
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $reference;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", inversedBy="projets")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="projets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeleARealiser", mappedBy="projet")
     */
    private $modeles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="projet")
     */
    private $devis;

    public function __toString()
    {
        return $this->type;
    }

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->modeles = new ArrayCollection();
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|ModeleARealiser[]
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    public function addModele(ModeleARealiser $modele): self
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles[] = $modele;
            $modele->setProjet($this);
        }

        return $this;
    }

    public function removeModele(ModeleARealiser $modele): self
    {
        if ($this->modeles->contains($modele)) {
            $this->modeles->removeElement($modele);
            // set the owning side to null (unless already changed)
            if ($modele->getProjet() === $this) {
                $modele->setProjet(null);
            }
        }

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
            $devi->setProjet($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->contains($devi)) {
            $this->devis->removeElement($devi);
            // set the owning side to null (unless already changed)
            if ($devi->getProjet() === $this) {
                $devi->setProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return array|Module[]
     */
    public function getModules(): array
    {
        $result = [];
        foreach ($this->getProduits() as $produit) {
            $gamme = $produit->getGamme();
            $modele = $gamme->getModele();
            foreach ($modele->getModules() as $module) {
                $result[] = $module;
            }
        }
        return $result;
    }
}

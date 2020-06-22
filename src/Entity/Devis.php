<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 *
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class Devis
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EtatDevis", inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    /**
     * @return string
     */
    public function __toString(): string
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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    public function getEtat(): ?EtatDevis
    {
        return $this->etat;
    }

    public function setEtat(?EtatDevis $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return array|Modele[]
     */
    public function getModeles(): array
    {
        $result = [];
        foreach ($this->getProjet()->getProduits() as $produit) {
            /** @var Gamme $gamme */
            $gamme = $produit->getGamme();
            /** @var Modele $modele */
            $modele = $gamme->getModele();
            $result[] = $modele;
        }
        return $result;
    }


    /**
     * @return array|Module[]
     */
    public function getModules(): array
    {
        $result = [];
        foreach ($this->getProjet()->getProduits() as $produit) {
            /** @var Gamme $gamme */
            $gamme = $produit->getGamme();
            /** @var Modele $modele */
            $modele = $gamme->getModele();
            foreach ($modele->getModules() as $module) {
                $result[] = $module;
            }
        }
        return $result;
    }

    /**
     * @return array|Composant[]
     */
    public function getComposants(): array
    {
        $result = [];
        $produits = $this->getProjet()->getProduits();
        foreach ($produits as $produit) {
            $gamme = $produit->getGamme();
            $modele = $gamme->getModele();
            foreach ($modele->getModules() as $module) {
                foreach ($module->getModuleComposant() as $composant) {
                    $result[] = $composant;
                }
            }
        }
        return $result;
    }

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }
}

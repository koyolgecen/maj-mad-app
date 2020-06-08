<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\PaiementEchelonne", inversedBy="devis")
     */
    private $paiementEchelonne;

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

    public function getPaiementEchelonne(): ?PaiementEchelonne
    {
        return $this->paiementEchelonne;
    }

    public function setPaiementEchelonne(?PaiementEchelonne $paiementEchelonne): self
    {
        $this->paiementEchelonne = $paiementEchelonne;

        return $this;
    }
}

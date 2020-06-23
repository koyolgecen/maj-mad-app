<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 *
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class Commande
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Livraison", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $livraison;

    /**
     * @var Devis|null
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Devis", inversedBy="commande")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $devis;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    /**
     * @return Devis|null
     */
    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    /**
     * @param Devis|null $devis
     */
    public function setDevis(?Devis $devis): void
    {
        $this->devis = $devis;
    }
}

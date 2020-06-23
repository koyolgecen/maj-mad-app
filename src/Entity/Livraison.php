<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivraisonRepository")
 */
class Livraison
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDeLivraison;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $codePostale;

    /**
     * @var Commande|null
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", inversedBy="livraison")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeLivraison(): ?\DateTimeInterface
    {
        return $this->dateDeLivraison;
    }

    public function setDateDeLivraison(\DateTimeInterface $dateDeLivraison): self
    {
        $this->dateDeLivraison = $dateDeLivraison;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostale(): ?string
    {
        return $this->codePostale;
    }

    public function setCodePostale(string $codePostale): self
    {
        $this->codePostale = $codePostale;

        return $this;
    }

    /**
     * @return Commande|null
     */
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    /**
     * @param Commande|null $commande
     */
    public function setCommande(?Commande $commande): void
    {
        $this->commande = $commande;
    }
}

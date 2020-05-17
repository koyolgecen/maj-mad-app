<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleARealiserRepository")
 *
 * @author Clément COURTET <clement.courtet@viacesi.fr>
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 */
class ModuleARealiser
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
     * @ORM\Column(type="string", length=50)
     */
    private $modeConception;

    /**
     * @ORM\Column(type="float")
     */
    private $longueur;

    /**
     * @ORM\Column(type="float")
     */
    private $largeur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeleARealiser", inversedBy="modules")
     */
    private $modele;

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

    public function getModeConception(): ?string
    {
        return $this->modeConception;
    }

    public function setModeConception(string $modeConception): self
    {
        $this->modeConception = $modeConception;

        return $this;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getModele(): ?ModeleARealiser
    {
        return $this->modele;
    }

    public function setModele(?ModeleARealiser $modele): self
    {
        $this->modele = $modele;

        return $this;
    }
}

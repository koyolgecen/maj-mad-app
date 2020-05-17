<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureRepository")
 *
 * @author Mithat GOKSEN <mithat.goksen@viacesi.fr>
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class Nature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $nomNature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CaracteristiqueNature", inversedBy="natures")
     */
    private $caracteristiqueNature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UniteNature", inversedBy="natures")
     */
    private $uniteNature;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomNature;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomNature(): ?string
    {
        return $this->nomNature;
    }

    public function setNomNature(string $nomNature): self
    {
        $this->nomNature = $nomNature;

        return $this;
    }

    /**
     * @return CaracteristiqueNature
     */
    public function getCaracteristiqueNature(): ?CaracteristiqueNature
    {
        return $this->caracteristiqueNature;
    }

    /**
     * @param CaracteristiqueNature|null $caracteristiqueNature
     */
    public function setCaracteristiqueNature(?CaracteristiqueNature $caracteristiqueNature): void
    {
        $this->caracteristiqueNature = $caracteristiqueNature;
    }

    /**
     * @return UniteNature
     */
    public function getUniteNature(): ?UniteNature
    {
        return $this->uniteNature;
    }

    /**
     * @param UniteNature|null $uniteNature
     */
    public function setUniteNature(?UniteNature $uniteNature): void
    {
        $this->uniteNature = $uniteNature;
    }
}

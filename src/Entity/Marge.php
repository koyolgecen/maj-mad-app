<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MargeRepository")
 */
class Marge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $MargeEntreprise;

    /**
     * @ORM\Column(type="float")
     */
    private $MargeCommerciale;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMargeEntreprise(): ?float
    {
        return $this->MargeEntreprise;
    }

    public function setMargeEntreprise(float $MargeEntreprise): self
    {
        $this->MargeEntreprise = $MargeEntreprise;

        return $this;
    }

    public function getMargeCommerciale(): ?float
    {
        return $this->MargeCommerciale;
    }

    public function setMargeCommerciale(float $MargeCommerciale): self
    {
        $this->MargeCommerciale = $MargeCommerciale;

        return $this;
    }
}

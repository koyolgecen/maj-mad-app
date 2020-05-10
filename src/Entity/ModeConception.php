<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeConceptionRepository")
 */
class ModeConception
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
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RegleCalcul", inversedBy="modeConceptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regleCalcul;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gamme", mappedBy="modeConception")
     */
    private $gammes;

    public function __toString()
    {
        return $this->type;
    }

    public function __construct()
    {
        $this->gammes = new ArrayCollection();
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

    public function getRegleCalcul(): ?RegleCalcul
    {
        return $this->regleCalcul;
    }

    public function setRegleCalcul(?RegleCalcul $regleCalcul): self
    {
        $this->regleCalcul = $regleCalcul;

        return $this;
    }

    /**
     * @return Collection|Gamme[]
     */
    public function getGammes(): Collection
    {
        return $this->gammes;
    }

    public function addGamme(Gamme $gamme): self
    {
        if (!$this->gammes->contains($gamme)) {
            $this->gammes[] = $gamme;
            $gamme->setModeConception($this);
        }

        return $this;
    }

    public function removeGamme(Gamme $gamme): self
    {
        if ($this->gammes->contains($gamme)) {
            $this->gammes->removeElement($gamme);
            // set the owning side to null (unless already changed)
            if ($gamme->getModeConception() === $this) {
                $gamme->setModeConception(null);
            }
        }

        return $this;
    }
}

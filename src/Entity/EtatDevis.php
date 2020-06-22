<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatDevisRepository")
 */
class EtatDevis
{
    public const BADGE_PRIMARY = 'primary';
    public const BADGE_SECONDARY = 'secondary';
    public const BADGE_SUCCESS = 'success';
    public const BADGE_DANGER = 'danger';
    public const BADGE_WARNING = 'warning';
    public const BADGE_INFO = 'info';
    public const BADGE_LIGHT = 'light';
    public const BADGE_DARK = 'dark';

    public const BADGES = [
        self::BADGE_PRIMARY => self::BADGE_PRIMARY,
        self::BADGE_SECONDARY => self::BADGE_SECONDARY,
        self::BADGE_SUCCESS => self::BADGE_SUCCESS,
        self::BADGE_DANGER => self::BADGE_DANGER,
        self::BADGE_WARNING => self::BADGE_WARNING,
        self::BADGE_INFO => self::BADGE_INFO,
        self::BADGE_LIGHT => self::BADGE_LIGHT,
        self::BADGE_DARK => self::BADGE_DARK
    ];

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
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="etat")
     */
    private $devis;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $commendable = false;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $badgeStyle = self::BADGE_SECONDARY;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

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
            $devi->setEtat($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->contains($devi)) {
            $this->devis->removeElement($devi);
            // set the owning side to null (unless already changed)
            if ($devi->getEtat() === $this) {
                $devi->setEtat(null);
            }
        }

        return $this;
    }

    public function isCommendable(): ?bool
    {
        return $this->commendable;
    }

    public function setCommendable(bool $commendable): self
    {
        $this->commendable = $commendable;

        return $this;
    }

    public function getBadgeStyle(): ?string
    {
        return $this->badgeStyle;
    }

    public function setBadgeStyle(string $badgeStyle): self
    {
        $this->badgeStyle = $badgeStyle;

        return $this;
    }
}

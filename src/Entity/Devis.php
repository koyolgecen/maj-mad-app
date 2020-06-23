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
    public const ETAT_BROUILLON = 'BROUILLON';
    public const ETAT_ACCEPTE = 'ACCEPTE';
    public const ETAT_EN_ATTENTE = 'EN_ATTENTE';
    public const ETAT_REFUSE = 'REFUSE';
    public const ETAT_EN_COMMANDE = 'EN_COMMANDE';
    public const ETAT_TRANSFERT_EN_FACTURATION = 'TRANSFERT_EN_FACTURATION';

    public const ETATS = [
      self::ETAT_BROUILLON,
      self::ETAT_ACCEPTE,
      self::ETAT_EN_ATTENTE,
      self::ETAT_REFUSE,
      self::ETAT_EN_COMMANDE,
      self::ETAT_TRANSFERT_EN_FACTURATION
    ];

    public const BADGE_PRIMARY = 'primary';
    public const BADGE_SECONDARY = 'secondary';
    public const BADGE_SUCCESS = 'success';
    public const BADGE_DANGER = 'danger';
    public const BADGE_WARNING = 'warning';
    public const BADGE_INFO = 'info';
    public const BADGE_LIGHT = 'light';
    public const BADGE_DARK = 'dark';

    public const BADGES = [
        self::ETAT_BROUILLON => self::BADGE_SECONDARY,
        self::ETAT_EN_COMMANDE => self::BADGE_PRIMARY,
        self::ETAT_ACCEPTE => self::BADGE_SUCCESS,
        self::ETAT_REFUSE => self::BADGE_DANGER,
        self::ETAT_EN_ATTENTE => self::BADGE_WARNING,
        self::ETAT_TRANSFERT_EN_FACTURATION => self::BADGE_INFO
    ];

    public const ETAPE_SIGNATURE = 'signature';
    public const ETAPE_PERMIS_DE_CONSTRUIRE = 'permis_de_construire';
    public const ETAPE_OUVERTURE_CHANTIER = 'ouverture_chantier';
    public const ETAPE_FONDATIONS = 'fondations';
    public const ETAPE_MURS = 'murs';
    public const ETAPE_HORS_EAU_HORS_AIR = 'hors_eau_hors_air';
    public const ETAPE_TRAVAUX = 'travaux';
    public const ETAPE_REMISE_CLE = 'remise_cle';

    public const ETAPES = [
        self::ETAPE_SIGNATURE => 0.03,
        self::ETAPE_PERMIS_DE_CONSTRUIRE => 0.1,
        self::ETAPE_OUVERTURE_CHANTIER => 0.15,
        self::ETAPE_FONDATIONS => 0.25,
        self::ETAPE_MURS => 0.4,
        self::ETAPE_HORS_EAU_HORS_AIR => 0.75,
        self::ETAPE_TRAVAUX => 0.95,
        self::ETAPE_REMISE_CLE => 1,
    ];

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
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $etat = self::ETAT_BROUILLON;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="devis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commande", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $commande;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
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

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}

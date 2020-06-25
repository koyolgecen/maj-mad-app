<?php

namespace App\Services;

use App\Entity\Devis;

/**
 * Class DevisService
 * @package App\Services
 *
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class DevisService
{
    /**
     * @param Devis $devis
     * @return array
     */
    public function getComposantsDetailled(Devis $devis): array
    {
        $result = [];
        foreach ($devis->getModules() as $module) {
            foreach ($module->getModuleComposant() as $key => $composant) {
                $prixWithMargeEnt = $this->prixWithMarge($composant->getPrix(), $composant->getMarge()->getMargeEntreprise());
                $prixWithMargeCom = $this->prixWithMarge($composant->getPrix(), $composant->getMarge()->getMargeCommerciale());
                $result[$module->getNom()][$key] = [
                    'composant' => $composant->getNature(),
                    'prixHT' => $prixWithMargeEnt + $prixWithMargeCom,
                    'quantite' => $module->getQuantite(),
                    'prixTTC' => $this->HTToTTC($prixWithMargeEnt + $prixWithMargeCom),
                    'fournisseurs' => $composant->getFournisseurs()
                ];
            }
        }
        return $result;
    }

    /**
     * @param Devis $devis
     * @return float|null
     */
    public function calculatePriceWithMargeHT(Devis $devis): ?float
    {
        return $this->getPrice($devis, false, true);
    }

    /**
     * @param Devis $devis
     * @return float|null
     */
    public function calculatePriceWithMargeTTC(Devis $devis): ?float
    {
        return $this->getPrice($devis, true, true);
    }

    /**
     * @param Devis $devis
     * @param bool $ttc
     * @param bool $withMarge
     * @return float|null
     */
    private function getPrice(Devis $devis, bool $ttc = false, bool $withMarge = false): ?float
    {
        $result = 0.0;
        foreach ($devis->getModules() as $module) {
            $resultModule = 0.0;
            foreach ($module->getModuleComposant() as $composant) {
                $qtt = $module->getQuantite();
                $prixWithMargeEnt = 0.0;
                $prixWithMargeCom = 0.0;
                if ($withMarge) {
                    $prixWithMargeEnt = $this->prixWithMarge($composant->getPrix(), $composant->getMarge()->getMargeEntreprise());
                    $prixWithMargeCom = $this->prixWithMarge($composant->getPrix(), $composant->getMarge()->getMargeCommerciale());
                }
                if ($ttc) {
                    $resultModule += $this->HTToTTC($withMarge ? ($prixWithMargeEnt + $prixWithMargeCom) : $composant->getPrix());
                } else {
                    $resultModule += $withMarge ? ($prixWithMargeEnt + $prixWithMargeCom) : $composant->getPrix();
                }
                $resultModule *= $qtt;
            }
            $result += $resultModule;
        }
        return $result;
    }

    /**
     * @param float $prix
     * @return float
     */
    public function HTToTTC(float $prix): float
    {
        return (($prix * 20) / 100) + $prix;
    }

    /**
     * @param float $prix
     * @param float $marge
     * @return float
     */
    private function prixWithMarge(float $prix, float $marge): float
    {
        return ($prix * $marge) + $prix;
    }
}
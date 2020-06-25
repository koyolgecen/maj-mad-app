<?php

namespace App\Services;

use App\Entity\Projet;

/**
 * Class DevisService
 * @package App\Services
 *
 * @author Konuralp YOLGECEN <konuralp.yolgecen@viacesi.fr>
 */
class ProjetService
{
    /**
     * @param Projet $projet
     * @return array
     */
    public function getComposantsDetailled(Projet $projet): array
    {
        $result = [];
        foreach ($projet->getModules() as $module) {
            foreach ($module->getModuleComposant() as $key => $composant) {
                $result[$module->getNom()][$key] = [
                    'composant' => $composant->getNature(),
                    'prixHT' => $composant->getPrix(),
                    'quantite' => $module->getQuantite()
                ];
            }
        }
        return $result;
    }
}
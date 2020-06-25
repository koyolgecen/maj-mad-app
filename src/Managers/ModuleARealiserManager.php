<?php

namespace App\Managers;

use App\Entity\ModuleARealiser;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;

class ModuleARealiserManager
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * ModuleARealiserManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Projet $projet
     */
    public function createModulesARealiser(Projet $projet): void
    {
        foreach ($projet->getModules() as $module) {
            $moduleARealiser = new ModuleARealiser();
            $moduleARealiser->setProjetId($projet->getId());
            $moduleARealiser->setModuleId($module->getId());
            $moduleARealiser->setNom($module->getNom());
            $moduleARealiser->setLargeur(0.0);
            $moduleARealiser->setLongueur(0.0);
            $this->em->persist($moduleARealiser);
        }
        $this->em->flush();
    }

}
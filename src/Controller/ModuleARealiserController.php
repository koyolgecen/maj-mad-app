<?php

namespace App\Controller;

use App\Entity\ModuleARealiser;
use App\Form\ModuleARealiserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ModuleARealiserController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_COMMERCIAL')")
 */
class ModuleARealiserController extends AbstractController
{
    /**
     * @Route("/modules-ar", name="modules_ar")
     */
    public function modules()
    {
        /** @var ModuleARealiser[] $modules */
        $modules = $this->getDoctrine()->getRepository( ModuleARealiser::class)->findAll();

        return $this->render('module_a_realiser/all_modules_ar.html.twig', [
            'modules' => $modules
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/module-ar-add", name="module_ar_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModuleARealiserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ModuleARealiser $module */
            $module = $form->getData();

            $em->persist($module);
            $em->flush();

            $this->addFlash('success', 'Nouveau module ajouté!');
            return $this->redirectToRoute('modules_ar');
        }

        return $this->render('module_a_realiser/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ModuleARealiser $module
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/module-ar/edit/{id}", name="module_ar_edit")
     *
     */
    public function edit(ModuleARealiser $module, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModuleARealiserType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($module);
            $em->flush();

            $this->addFlash('success', sprintf('Module "%s" modifié avec succès !', $module->getNom()));
            return $this->redirectToRoute('modules_ar');
        }

        return $this->render('module_a_realiser/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ModuleARealiser $module
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/module-ar/delete/{id}", name="module_ar_delete")
     */
    public function delete(ModuleARealiser $module, EntityManagerInterface $em)
    {
        $em->remove($module);
        $em->flush();

        $this->addFlash('success', 'Module supprimé avec succès !');
        return $this->redirectToRoute('modules_ar');
    }
}

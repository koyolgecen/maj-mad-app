<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ModuleController
 * @package App\Controller
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUREAU_DETUDE') or is_granted('ROLE_COMMERCIAL')")
 */
class ModuleController extends AbstractController
{
    /**
     * @Route("/modules", name="modules")
     */
    public function Modules()
    {
        /** @var Module[] $modules */
        $modules = $this->getDoctrine()->getRepository( Module::class)->findAll();

        return $this->render('module/all_module.html.twig', [
            'modules' => $modules
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/module-add", name="module_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModuleType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Module $module */
            $module = $form->getData();

            $em->persist($module);
            $em->flush();

            $this->addFlash('success', 'Nouveau module ajouté!');
            return $this->redirectToRoute('modules');
        }

        return $this->render('module/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Module $module
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/module/edit/{id}", name="module_edit")
     */
    public function edit(Module $module, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($module);
            $em->flush();

            $this->addFlash('success', sprintf('Module "%s" modifié avec succès !', $module->getNom()));
            return $this->redirectToRoute('modules');
        }

        return $this->render('module/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $module
        ]);
    }

    /**
     * @param Module $module
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/module/delete/{id}", name="module_delete")
     */
    public function delete(Module $module, EntityManagerInterface $em)
    {
        $em->remove($module);
        $em->flush();

        $this->addFlash('success', 'Module supprimé avec succès !');
        return $this->redirectToRoute('modules');
    }

}

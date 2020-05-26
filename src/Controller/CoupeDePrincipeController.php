<?php

namespace App\Controller;

use App\Entity\CoupeDePrincipe;
use App\Form\CoupeDePrincipeType;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoupeDePrincipeController extends AbstractController
{
    /**
     * @Route("/coupes-de-principe", name="coupes_de_principe")
     */
    public function CoupesDePrincipe()
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        /** @var CoupeDePrincipe[] $coupesPrincipe */
        $coupesPrincipe = $this->getDoctrine()->getRepository( CoupeDePrincipe::class)->findAll();

        return $this->render('coupe_de_principe/all_coupedeprincipe.html.twig', [
            'coupesdeprincipe' => $coupesPrincipe
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     *
     * @Route("/coupe-de-principe-add", name="coupe_de_principe_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        //$this->denyAccessUnlessGranted('ROLE_BUREAU_DETUDE');
        $form = $this->createForm(CoupeDePrincipeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CoupeDePrincipe $coupesPrincipe */
            $coupesPrincipe = $form->getData();

            $em->persist($coupesPrincipe);
            $em->flush();

            $this->addFlash('success', 'Nouvelle coupe de principe ajoutée!');
            return $this->redirectToRoute('coupes_de_principe');
        }

        return $this->render('coupe_de_principe/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @param CoupeDePrincipe $coupesPrincipe
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     *
     * @Route("/coupe-de-principe/edit/{id}", name="coupe_de_principe_edit")
     */
    public function edit(CoupeDePrincipe $coupesPrincipe, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CoupeDePrincipeType::class, $coupesPrincipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($coupesPrincipe);
            $em->flush();

            $this->addFlash('success', sprintf('Coupe de principe "%s" modifiée avec succès !', $coupesPrincipe->getNom()));
            return $this->redirectToRoute('coupes_de_principe');
        }

        return $this->render('coupe_de_principe/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $coupesPrincipe
        ]);
    }

    /**
     * @param CoupeDePrincipe $coupesPrincipe
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     *
     * @Route("/coupe-de-principe/delete/{id}", name="coupe_de_principe_delete")
     */
    public function delete(CoupeDePrincipe $coupesPrincipe, EntityManagerInterface $em)
    {
        try {
            $em->remove($coupesPrincipe);
            $em->flush();
            $this->addFlash('success', 'Coupe de principe supprimée avec succès !');
        } catch (DBALException $exception) {
            $this->addFlash('danger', sprintf('Suppression impossible ! La coupe de principe est liée aux modules "%s" !', implode(',',
                $coupesPrincipe->getModules()->toArray())));
        }
        return $this->redirectToRoute('coupes_de_principe');
    }
}

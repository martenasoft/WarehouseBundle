<?php

namespace MartenaSoft\Warehouse\Controller;

use MartenaSoft\Warehouse\Entity\Shelving;
use MartenaSoft\Warehouse\Form\ShelvingType;
use MartenaSoft\Warehouse\Repository\ShelvingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shelving")
 */
class ShelvingController extends AbstractController
{
    /**
     * @Route("/", name="shelving_index", methods={"GET"})
     */
    public function index(ShelvingRepository $shelvingRepository): Response
    {
        return $this->render('shelving/index.html.twig', [
            'shelvings' => $shelvingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shelving_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shelving = new Shelving();
        $form = $this->createForm(ShelvingType::class, $shelving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shelving);
            $entityManager->flush();

            return $this->redirectToRoute('shelving_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shelving/new.html.twig', [
            'shelving' => $shelving,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="shelving_show", methods={"GET"})
     */
    public function show(Shelving $shelving): Response
    {
        return $this->render('shelving/show.html.twig', [
            'shelving' => $shelving,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shelving_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shelving $shelving): Response
    {
        $form = $this->createForm(ShelvingType::class, $shelving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shelving_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shelving/edit.html.twig', [
            'shelving' => $shelving,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="shelving_delete", methods={"POST"})
     */
    public function delete(Request $request, Shelving $shelving): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shelving->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shelving);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shelving_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace MartenaSoft\Warehouse\Controller;

use MartenaSoft\Warehouse\Entity\Box;
use MartenaSoft\Warehouse\Form\BoxType;
use MartenaSoft\Warehouse\Repository\BoxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/box")
 */
class BoxController extends AbstractController
{
    /**
     * @Route("/", name="box_index", methods={"GET"})
     */
    public function index(BoxRepository $boxRepository): Response
    {
        return $this->render('@Warehouse/box/index.html.twig', [
            'boxes' => $boxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="box_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $box = new Box();
        $form = $this->createForm(BoxType::class, $box);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($box);
            $entityManager->flush();

            return $this->redirectToRoute('box_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('@Warehouse/box/new.html.twig', [
            'box' => $box,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="box_show", methods={"GET"})
     */
    public function show(Box $box): Response
    {
        return $this->render('@Warehouse/box/show.html.twig', [
            'box' => $box,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="box_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Box $box): Response
    {
        $form = $this->createForm(BoxType::class, $box);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('box_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('@Warehouse/box/edit.html.twig', [
            'box' => $box,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="box_delete", methods={"POST"})
     */
    public function delete(Request $request, Box $box): Response
    {
        if ($this->isCsrfTokenValid('delete'.$box->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($box);
            $entityManager->flush();
        }

        return $this->redirectToRoute('box_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace MartenaSoft\Warehouse\Controller;

use MartenaSoft\Warehouse\Entity\Warehouse;
use MartenaSoft\Warehouse\Form\WarehouseType;
use MartenaSoft\Warehouse\Repository\WarehouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/warehouse")
 */
class WarehouseController extends AbstractController
{
    /**
     * @Route("/", name="warehouse_index", methods={"GET"})
     */
    public function index(WarehouseRepository $warehouseRepository): Response
    {
        return $this->render('@Warehouse/warehouse/index.html.twig', [
            'warehouses' => $warehouseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="warehouse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $warehouse = new Warehouse();
        $form = $this->createForm(WarehouseType::class, $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($warehouse);
            $entityManager->flush();

            return $this->redirectToRoute('warehouse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('@Warehouse/warehouse/new.html.twig', [
            'warehouse' => $warehouse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="warehouse_show", methods={"GET"})
     */
    public function show(Warehouse $warehouse): Response
    {
        return $this->render('@Warehouse/warehouse/show.html.twig', [
            'warehouse' => $warehouse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="warehouse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Warehouse $warehouse): Response
    {
        $form = $this->createForm(WarehouseType::class, $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('warehouse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('@Warehouse/warehouse/edit.html.twig', [
            'warehouse' => $warehouse,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="warehouse_delete", methods={"POST"})
     */
    public function delete(Request $request, Warehouse $warehouse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$warehouse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($warehouse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('warehouse_index', [], Response::HTTP_SEE_OTHER);
    }
}

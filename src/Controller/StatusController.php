<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\Inventory\StatusType;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/status")
 */
class StatusController extends Controller
{
    /**
     * @Route("/", name="status_index", methods="GET")
     */
    public function index(StatusRepository $statusRepository): Response
    {
        return $this->render('Admin/Inventory/status/index.html.twig', ['statuses' => $statusRepository->findAll()]);
    }

    /**
     * @Route("/new", name="status_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();
            $this->addFlash('success','The Status have been created!');
            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('Admin/Inventory/status/new.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="status_show", methods="GET")
     */
    public function show(Status $status): Response
    {
        return $this->render('Admin/Inventory/status/show.html.twig', ['status' => $status]);
    }

    /**
     * @Route("/{id}/edit", name="status_edit", methods="GET|POST")
     */
    public function edit(Request $request, Status $status): Response
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','The Status have been updated!');
            return $this->redirectToRoute('status_edit', ['id' => $status->getId()]);
        }

        return $this->render('Admin/Inventory/status/edit.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="status_delete", methods="DELETE")
     */
    public function delete(Request $request, Status $status): Response
    {
        if ($this->isCsrfTokenValid('delete'.$status->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status);
            $em->flush();
            $this->addFlash('success','The Status have been deleted!');
        }

        return $this->redirectToRoute('inventory_index');
    }
}

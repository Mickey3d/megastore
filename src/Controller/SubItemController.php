<?php

namespace App\Controller;

use App\Entity\SubItem;
use App\Form\Inventory\SubItemType;
use App\Repository\SubItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sub/item")
 */
class SubItemController extends Controller
{
    /**
     * @Route("/", name="sub_item_index", methods="GET")
     */
    public function index(SubItemRepository $subItemRepository): Response
    {
        return $this->render('Admin/Inventory/sub_item/index.html.twig', ['sub_items' => $subItemRepository->findAll()]);
    }

    /**
     * @Route("/new", name="sub_item_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $subItem = new SubItem();
        $form = $this->createForm(SubItemType::class, $subItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subItem);
            $em->flush();
            $this->addFlash('success','The SubItem have been created!');
            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('Admin/Inventory/sub_item/new.html.twig', [
            'sub_item' => $subItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sub_item_show", methods="GET")
     */
    public function show(SubItem $subItem): Response
    {
        return $this->render('Admin/Inventory/sub_item/show.html.twig', ['sub_item' => $subItem]);
    }

    /**
     * @Route("/{id}/edit", name="sub_item_edit", methods="GET|POST")
     */
    public function edit(Request $request, SubItem $subItem): Response
    {
        $form = $this->createForm(SubItemType::class, $subItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','The SubItem have been updated!');
            return $this->redirectToRoute('sub_item_edit', ['id' => $subItem->getId()]);
        }

        return $this->render('Admin/Inventory/sub_item/edit.html.twig', [
            'sub_item' => $subItem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sub_item_delete", methods="DELETE")
     */
    public function delete(Request $request, SubItem $subItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subItem->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subItem);
            $em->flush();
            $this->addFlash('success','The SubItem have been deleted!');
        }

        return $this->redirectToRoute('inventory_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\Inventory\ItemType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/item")
 */
class ItemController extends Controller
{
    /**
     * @Route("/", name="item_index", methods="GET")
     */
    public function index(ItemRepository $itemRepository): Response
    {
        return $this->render('Admin/Inventory/item/index.html.twig', ['items' => $itemRepository->findAll()]);
    }

    /**
     * @Route("/new", name="item_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            $this->addFlash('success','The Item have been created!');
            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('Admin/Inventory/item/new.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_show", methods="GET")
     */
    public function show(Item $item): Response
    {
        return $this->render('Admin/Inventory/item/show.html.twig', ['item' => $item]);
    }

    /**
     * @Route("/{id}/edit", name="item_edit", methods="GET|POST")
     */
    public function edit(Request $request, Item $item): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','The Item have been updated!');
            return $this->redirectToRoute('item_edit', ['id' => $item->getId()]);
        }

        return $this->render('Admin/Inventory/item/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_delete", methods="DELETE")
     */
    public function delete(Request $request, Item $item): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
            $this->addFlash('success','The Item have been deleted!');
        }

        return $this->redirectToRoute('inventory_index');
    }
}

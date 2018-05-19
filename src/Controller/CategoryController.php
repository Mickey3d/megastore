<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use App\Form\Inventory\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="category_index", methods="GET")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('Admin/Inventory/category/index.html.twig', ['categories' => $categoryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="category_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $subCategories = $category->getSubCategories();

            foreach ($subCategories as $subCategory) {
              $category->addSubCategory($subCategory);
              $subCategory->setCategory($category);
              $em->persist($subCategory);
            }

            $em->flush();
            $this->addFlash('success','The Category have been created!');
            return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);
        }

        return $this->render('Admin/Inventory/category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods="GET")
     */
    public function show(Category $category): Response
    {
        return $this->render('Admin/Inventory/category/show.html.twig', ['category' => $category]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods="GET|POST")
     */
    public function edit(Request $request, Category $category): Response
    {

        $em = $this->getDoctrine()->getManager();
        $originalSubCat = new ArrayCollection();
        // Create an ArrayCollection of the current SubCategory objects in the database
        foreach ($category->getSubCategories() as $subCategory) {
          $originalSubCat->add($subCategory);
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          // remove the relationship between the SubCat and the Category
          foreach ($originalSubCat as $subCategory) {
            if (false === $category->getSubCategories()->contains($subCategory)) {
              // remove the Cat from the SubCat
              $subCategory->getCategory()->removeSubCategory($subCategory);
              $em->persist($subCategory);
              $em->remove($subCategory);
            }
          }
          $subCategories = $category->getSubCategories();

          foreach ($subCategories as $subCategory) {
            $category->addSubCategory($subCategory);
            $subCategory->setCategory($category);
            $em->persist($subCategory);
          }

          $em->persist($category);
          $em->flush();
          $this->addFlash('success','The Category have been updated!');
          return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);

        }

        return $this->render('Admin/Inventory/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="category_delete", methods="DELETE")
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
            $this->addFlash('success','The Category have been deleted!');
        }

        return $this->redirectToRoute('inventory_index');
    }
}

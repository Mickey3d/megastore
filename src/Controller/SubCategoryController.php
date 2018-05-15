<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\Inventory\SubCategoryType;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/subcategory")
 */
class SubCategoryController extends Controller
{

    /**
    * @Route("/get-subcategories-from-category", name="sub_category_item_list", methods="GET")
    */
    public function listSubCategoriesOfCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subCategoriesRepository = $em->getRepository(SubCategory::class);

        // Search the SubCategories that belongs to the Category with the given id as GET parameter "categoryid"
        $subCategories = $subCategoriesRepository->createQueryBuilder("q")
            ->where("q.category = :categoryid")
            ->setParameter("categoryid", $request->query->get("categoryid"))
            ->getQuery()
            ->getResult();

            $responseArray = array();
            foreach($subCategories as $subCategory){
              $responseArray[] = array(
                "id" => $subCategory->getId(),
                "name" => $subCategory->getSubEntityName()
              );
            }
     return new JsonResponse($responseArray);
    }

    /**
     * @Route("/", name="sub_category_index", methods="GET")
     */
    public function index(SubCategoryRepository $subCategoryRepository): Response
    {
        return $this->render('Admin/Inventory/sub_category/index.html.twig', ['sub_categories' => $subCategoryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="sub_category_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $subCategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subCategory);
            $em->flush();
            $this->addFlash('success','The Sub-Category have been created!');
            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('Admin/Inventory/sub_category/new.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sub_category_show", methods="GET")
     */
    public function show(SubCategory $subCategory): Response
    {
        return $this->render('Admin/Inventory/sub_category/show.html.twig', ['sub_category' => $subCategory]);
    }

    /**
     * @Route("/{id}/edit", name="sub_category_edit", methods="GET|POST")
     */
    public function edit(Request $request, SubCategory $subCategory): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','The Sub-Category have been updated!');
            return $this->redirectToRoute('sub_category_edit', ['id' => $subCategory->getId()]);
        }

        return $this->render('Admin/Inventory/sub_category/edit.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sub_category_delete", methods="DELETE")
     */
    public function delete(Request $request, SubCategory $subCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subCategory->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subCategory);
            $em->flush();
            $this->addFlash('success','The Sub-Category have been deleted!');
        }

        return $this->redirectToRoute('inventory_index');
    }


}

<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/category/{id}/", name="category_by_id", methods={"GET"})
     */
    public function showCategoryByIdAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Category');
        $category = $repo->find($id);

        return $this->render('@MoviePortal/Category/categoryById.html.twig', ['category'=> $category]);
    }

    /**
     * @Route("/admin/category/new/", name="new_category", methods={"GET"})
     */
    public function newCategoryAction()
    {
        $category = new Category();
        $form = $this->createForm('MoviePortalBundle\Form\CategoryFormType', $category);

        return $this->render('@MoviePortal/Category/categoryForm.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/admin/category/new/", name="save_new_category", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function newCategorySaveAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('MoviePortalBundle\Form\CategoryFormType', $category);

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('show_all_categories');
        }

        return $this->redirectToRoute('new_category');

    }

    /**
     * @return Response
     * @Route("/admin/category/all/", methods={"GET"}, name="show_all_categories")
     */
    public function showAllCategoryAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Category');
        $categories = $repo->findAll();

        return $this->render('@MoviePortal/Category/showAllCategories.html.twig', ['categories' => $categories]);

    }

    /**
     * @param $id
     * @Route("/admin/category/delete/{id}", name="delete_category")
     * @return RedirectResponse
     */
    public function deleteCategoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Category');
        $category = $repo->find($id);

        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('show_all_categories');
    }
}

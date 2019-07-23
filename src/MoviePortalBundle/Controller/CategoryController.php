<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package MoviePortalBundle\Controller
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/{id}/", name="category_by_id", methods={"GET"})
     */
    public function showCategoryByIdAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Category');
        $category = $repo->find($id);

        return $this->render('@MoviePortal/Category/categoryById.html.twig', ['category'=> $category]);
    }
}

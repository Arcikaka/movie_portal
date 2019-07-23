<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DirectorController
 * @package MoviePortalBundle\Controller
 * @Route("/director")
 */
class DirectorController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/{id}/", methods={"GET"}, name="director_by_id")
     */
    public function showDirectorByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Director');
        $director = $repo->find($id);

        return $this->render('@MoviePortal/Director/directorById.html.twig', ['director' => $director]);
    }
}

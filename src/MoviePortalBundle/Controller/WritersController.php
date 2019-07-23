<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WritersController
 * @package MoviePortalBundle\Controller
 * @Route("/writers")
 */
class WritersController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/{id}", methods={"GET"}, name="writer_by_id")
     */
    public function showWritersByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Writers');
        $writer = $repo->find($id);

        return $this->render('@MoviePortal/Writers/WritersById.html.twig', ['writer' => $writer]);
    }
}

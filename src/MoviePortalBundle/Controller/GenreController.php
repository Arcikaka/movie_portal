<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenreController
 * @package MoviePortalBundle\Controller
 * @Route("/genre")
 */
class GenreController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/{id}/", name="genre_by_id", methods={"GET"})
     */
    public function showGenreByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Genre');
        $genre = $repo->find($id);

        return $this->render('@MoviePortal/Genre/GenreById.html.twig', ['genre' => $genre]);
    }
}

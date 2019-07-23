<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovieController
 * @package MoviePortalBundle\Controller
 * @Route("/movie")
 */
class MovieController extends Controller
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/", name="movie_by_id", methods={"GET"})
     */
    public function showMovieByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movie = $repo->find($id);

        return $this->render('@MoviePortal/Movie/MovieById.html.twig', ['movie'=> $movie]);
    }
}

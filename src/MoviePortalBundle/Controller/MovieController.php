<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     * @Route("/{id}/", name="movie_by_id", methods={"GET"})
     */
    public function showMovieByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movie = $repo->find($id);

        return $this->render('@MoviePortal/Movie/MovieById.html.twig', ['movie' => $movie]);
    }

    /**
     * @Route("/", methods={"GET"}, name="show_all_movies_anonymous")
     */
    public function showAllMoviesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movies = $repo->findAll();

        return $this->render('@MoviePortal/Movie/showAllMovies.html.twig', ['movies' => $movies]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/", methods={"POST"}, name="show_all_movies_query")
     */
    public function showAllMoviesByQueryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movies = $repo->searchMovieDatabase($request->get('string'));

        return $this->render('@MoviePortal/Movie/showAllMovies.html.twig', ['movies' => $movies]);

    }
}

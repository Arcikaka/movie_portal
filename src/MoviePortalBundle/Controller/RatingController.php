<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Movie;
use MoviePortalBundle\Entity\Rating;
use MoviePortalBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RatingController
 * @package MoviePortalBundle\Controller
 * @Route("/rating")
 */
class RatingController extends Controller
{
    /**
     * @Route("/new/{movieId}/", name="new_rating_form", methods={"GET"})
     * @param $movieId
     * @return Response
     */
    public function newRatingFormAction($movieId)
    {
        return $this->render('@MoviePortal/Rating/ratingFormInHtml.html.twig', ['movieId' => $movieId]);
    }

    /**
     * @param Request $request
     * @param $movieId
     * @return RedirectResponse
     * @Route("/new/{movieId}/", name="new_rating_save", methods={"POST"})
     */
    public function newRatingAction(Request $request, $movieId)
    {
        $em = $this->getDoctrine()->getManager();

        $ratingRepo = $em->getRepository('MoviePortalBundle:Rating');
        //checking, if in database is any record with specific data, if yes then controller updates rating
        $ratings = $ratingRepo->getRatingByMovieAndUser($movieId, $this->container->get('security.token_storage')
            ->getToken()->getUser()->getId());
        if ($ratings) {
            $rating = $ratings[0];
            $rating->setScore($request->get('score'));
            $em->flush();

            return $this->redirectToRoute('movie_by_id', ['id' => $movieId]);
        }

        $rating = new Rating();

        $em = $this->getDoctrine()->getManager();

        $rating->setScore($request->get('score'));
        $userRepo = $em->getRepository('MoviePortalBundle:User');
        $userRated = $userRepo->find($this->container->get('security.token_storage')->getToken()->getUser()->getId());

        $rating->setUser($userRated);

        $repoMovie = $em->getRepository('MoviePortalBundle:Movie');
        /** @var Movie $movieToRate */
        $movieToRate = $repoMovie->find($movieId);
        $rating->setMovies($movieToRate);

        /** @var User $userRated */
        $userRated->addRating($rating);
        $movieToRate->addRating($rating);


        $em->persist($rating);
        $em->flush();

        return $this->redirectToRoute('movie_by_id', ['id' => $movieId]);
    }

    /**
     * @return Response
     * @Route("/showAll/", name="show_all_ratings_by_user", methods={"GET"})
     */
    public function showAllRatingsByUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Rating');

        $ratings = $repo->showAllRatingsByUser($this->container->get('security.token_storage')->getToken()->getUser()->getId());

        return $this->render('@MoviePortal/Rating/showAllRatingsByUser.html.twig', ['ratings' => $ratings]);
    }
}

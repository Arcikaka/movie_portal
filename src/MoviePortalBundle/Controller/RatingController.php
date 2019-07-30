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
     * @Route("/{movieId}/{userId}/", name="new_rating_form", methods={"GET"})
     * @param $movieId
     * @param $userId
     * @return Response
     */
    public function newRatingFormAction($movieId, $userId)
    {
        $rating = new Rating();
        //$form = $this->createForm('MoviePortalBundle\Form\RatingFormType', $rating);

        //return $this->render('@MoviePortal/Rating/ratingForm.html.twig', ['form' => $form->createView()]);

        return $this->render('@MoviePortal/Rating/ratingFormInHtml.html.twig', ['movieId' => $movieId, 'userId' => $userId]);
    }

    /**
     * @param Request $request
     * @param $movieId
     * @param $userId
     * @return RedirectResponse
     * @Route("/{movieId}/{userId}/", name="new_rating_save", methods={"POST"})
     */
    public function newRatingAction(Request $request, $movieId, $userId)
    {
        $rating = new Rating();

        $em = $this->getDoctrine()->getManager();

        $rating->setScore($request->get('score'));

        $repoUser = $em->getRepository('MoviePortalBundle:User');
        /** @var User $user */
        $user = $repoUser->find($userId);
        $rating->addUser($user);

        $repoMovie = $em->getRepository('MoviePortalBundle:Movie');
        /** @var Movie $movieToRate */
        $movieToRate = $repoMovie->find($movieId);
        $rating->addMovies($movieToRate);
        /** @var Movie $movie */
        foreach ($rating->getMovies() as $movie) {
            $movie->addRating($rating);
        }
        /** @var User $user */
        foreach ($rating->getUser() as $user) {
            $user->addMovieRating($rating);
        }


        $em->persist($rating);
        $em->flush();

        return $this->redirectToRoute('movie_by_id', ['id' => $movieId]);

    }


    public function modifyRatingAction()
    {
        //TODO
    }
}

<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Movie;
use MoviePortalBundle\Entity\Rating;
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
        $form = $this->createForm('MoviePortalBundle\Form\RatingFormType', $rating);

        return $this->render('@MoviePortal/Rating/ratingForm.html.twig', ['form' => $form->createView()]);

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
        $form = $this->createForm('MoviePortalBundle\Form\RatingFormType', $rating);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->addUser($request->get('user'));
            $rating->addMovies($request->get('movies'));
            /** @var Movie $movie */
            foreach ($rating->getMovies() as $movie) {
                $movie->addRating($rating);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('movie_by_id', ['id' => $request->get('movies')]);
        }

        return $this->redirectToRoute('new_rating_form' . ['movieId' => $movieId, 'userId' => $userId]);
    }


    public function modifyRatingAction()
    {
        //TODO
    }
}

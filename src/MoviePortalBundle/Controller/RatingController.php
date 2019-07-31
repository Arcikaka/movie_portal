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
     * @Route("/{movieId}/", name="new_rating_form", methods={"GET"})
     * @param $movieId
     * @return Response
     */
    public function newRatingFormAction($movieId)
    {
        $rating = new Rating();
        $form = $this->createForm('MoviePortalBundle\Form\RatingFormType', $rating);

        //return $this->render('@MoviePortal/Rating/ratingForm.html.twig', ['form' => $form->createView(), 'movieId' => $movieId]);

        return $this->render('@MoviePortal/Rating/ratingFormInHtml.html.twig', ['movieId' => $movieId]);
    }

    /**
     * @param Request $request
     * @param $movieId
     * @return RedirectResponse
     * @Route("/{movieId}/", name="new_rating_save", methods={"POST"})
     */
    public function newRatingAction(Request $request, $movieId)
    {
        $rating = new Rating();
        //$form = $this->createForm('MoviePortalBundle\Form\RatingFormType', $rating);

        //$form->handleRequest($request);

        //if($form->isValid() && $form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $rating->setScore($request->get('score'));

            $userRepo = $em->getRepository('MoviePortalBundle:User');
            $userRated = $userRepo->find($this->container->get('security.token_storage')->getToken()->getUser()->getId());
            //$rating->setUser($this->container->get('security.token_storage')->getToken()->getUser());

            $rating->setUser($userRated);

            $repoMovie = $em->getRepository('MoviePortalBundle:Movie');
            /** @var Movie $movieToRate */
            $movieToRate = $repoMovie->find($movieId);
            $rating->addMovies($movieToRate);


            /** @var Movie $movie */
            foreach ($rating->getMovies() as $movie) {
                $movie->addRating($rating);
            }


            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('movie_by_id', ['id' => $movieId]);
        //}

        //return $this->redirectToRoute('new_rating_form', ['movieId' => $movieId]);


    }


    public function modifyRatingAction()
    {
        //TODO
    }
}

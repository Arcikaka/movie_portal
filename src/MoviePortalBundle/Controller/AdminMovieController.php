<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Actor;
use MoviePortalBundle\Entity\Director;
use MoviePortalBundle\Entity\Genre;
use MoviePortalBundle\Entity\Writers;
use MoviePortalBundle\Service\FileUploader;
use MoviePortalBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminMovieController
 * @package MoviePortalBundle\Controller
 * @Route("/admin/movie")
 *
 */
class AdminMovieController extends Controller
{
    /**
     * @return Response
     * @Route("/new/", name="new_movie_form", methods={"GET"})
     */
    public function newMovieAction()
    {
        $movie = new Movie();
        $form = $this->createForm('MoviePortalBundle\Form\MovieFormType', $movie);

        return $this->render('@MoviePortal/Movie/movieForm.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return RedirectResponse
     * @Route("/new/", name="save_new_movie", methods={"POST"})
     */
    public function newMovieSaveAction(Request $request, FileUploader $fileUploader)
    {
        $movie = new Movie();
        $form = $this->createForm('MoviePortalBundle\Form\MovieFormType', $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $posterFile */
            $posterFile = $form['poster']->getData();
            if ($posterFile) {
                $posterFileName = $fileUploader->upload($posterFile);
                $movie->setPoster($posterFileName);
            }
            /**
             * @var Director $director
             */
            foreach ($movie->getDirector() as $director) {
                $director->addMovies($movie);
            }
            /** @var Writers $writer */
            foreach ($movie->getWriters() as $writer) {
                $writer->addMovies($movie);
            }
            /** @var Actor $actor */
            foreach ($movie->getActors() as $actor) {
                $actor->addMovies($movie);
            }
            /** @var Genre $genre */
            foreach ($movie->getGenre() as $genre) {
                $genre->addMovies($movie);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('show_all_movies');
        }

        return $this->redirectToRoute('new_movie_form');

    }

    /**
     * @Route("/modify/{id}/", name="modify_movie_form", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function modifyMovieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movie = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\MovieFormType', $movie);

        return $this->render('@MoviePortal/Movie/modifyMovie.html.twig', ['form' => $form->createView(), 'movie' => $movie]);

    }

    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return RedirectResponse
     * @Route("/modify/{id}/", name="modify_movie", methods={"POST"})
     */
    public function modifyMovieSaveAction(Request $request, FileUploader $fileUploader, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movie = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\MovieFormType', $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $posterFile */
            $posterFile = $form['poster']->getData();
            if ($posterFile) {
                $posterFileName = $fileUploader->upload($posterFile);
                $movie->setPoster($posterFileName);
            }
            /**
             * @var Director $director
             */
            foreach ($movie->getDirector() as $director) {
                $director->addMovies($movie);
            }
            /** @var Writers $writer */
            foreach ($movie->getWriters() as $writer) {
                $writer->addMovies($movie);
            }
            /** @var Actor $actor */
            foreach ($movie->getActors() as $actor) {
                $actor->addMovies($movie);
            }
            /** @var Genre $genre */
            foreach ($movie->getGenre() as $genre) {
                $genre->addMovies($movie);
            }
            $em->flush();

            return $this->redirectToRoute('show_all_movies');
        }

        return $this->redirectToRoute('modify_movie_form', ['id' => $id]);
    }

    /**
     * @Route("/delete/{id}/", name="delete_movie_form", methods={"GET"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteMovieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Movie');
        $movie = $repo->find($id);

        $em->remove($movie);
        $em->flush();

        return $this->redirectToRoute('show_all_movies');

    }

    /**
     * @Route("/", name="show_all_movies", methods={"GET"})
     */
    public function showAllMovies()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Movie');
        $movies = $repo->findAll();

        return $this->render('@MoviePortal/Movie/showAllMoviesAdmin.html.twig', ['movies' => $movies]);

    }

    /**
     * @Route("/find/", name="find_movie", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function findMovieAction(Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Movie');
        $string = $request->get('string');
        $movies = $repo->searchMovieDatabase($string);

        return $this->render('@MoviePortal/Movie/showAllMoviesAdmin.html.twig', ['movies' => $movies]);
    }
}

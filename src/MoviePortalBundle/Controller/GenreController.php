<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Genre;
use MoviePortalBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GenreController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/genre/{id}/", name="genre_by_id", methods={"GET"})
     */
    public function showGenreByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Genre');
        $genre = $repo->find($id);

        return $this->render('@MoviePortal/Genre/GenreById.html.twig', ['genre' => $genre]);
    }

    /**
     * @return Response
     * @Route("/admin/genre/new/", name="new_genre_form", methods={"GET"})
     */
    public function newGenreAction()
    {
        $genre = new Genre();
        $form = $this->createForm('MoviePortalBundle\Form\GenreFormType', $genre);

        return $this->render('@MoviePortal/Genre/genreForm.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/admin/genre/new/", name="save_new_genre", methods={"POST"})
     */
    public function newGenreSaveAction(Request $request)
    {
        $genre = new Genre();
        $form = $this->createForm('MoviePortalBundle\Form\GenreFormType', $genre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('show_all_genres');
        }

        return $this->redirectToRoute('new_genre_form');

    }

    /**
     * @Route("/admin/genre/modify/{id}/", name="modify_genre_form", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function modifyGenreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Genre');
        $genre = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\GenreFormType', $genre);

        return $this->render('@MoviePortal/Genre/modifyGenre.html.twig', ['form' => $form->createView(), 'genre'=>$genre]);

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/admin/genre/modify/{id}/", name="modify_genre", methods={"POST"})
     * @return RedirectResponse
     */
    public function modifyGenreSaveAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Genre');
        $genre = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\GenreFormType', $genre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_all_genres');
        }

        return $this->redirectToRoute('modify_genre_form');
    }

    /**
     * @Route("/admin/genre/delete/{id}/", name="delete_genre_form", methods={"GET"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteGenreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Genre');
        $genre = $repo->find($id);
        /** @var Movie $movie */
        foreach ($genre->getMovies() as $movie){
            $movie->removeGenre($genre);
        }
        $em->remove($genre);
        $em->flush();

        return $this->redirectToRoute('show_all_genres');

    }

    /**
     * @Route("/admin/genre/", name="show_all_genres", methods={"GET"})
     */
    public function showAllGenres()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Genre');
        $genres = $repo->findAll();

        return $this->render('@MoviePortal/Genre/showAllGenres.html.twig', ['genres' => $genres]);

    }

    /**
     * @Route("/admin/genre/find/", name="find_genre", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function findGenreAction(Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Genre');
        $string = $request->get('string');
        $genres = $repo->searchGenres($string);

        return $this->render('@MoviePortal/Genre/showAllGenres.html.twig', ['genres' => $genres]);
    }
}

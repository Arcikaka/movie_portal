<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Director;
use MoviePortalBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DirectorController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/director/{id}/", methods={"GET"}, name="director_by_id")
     */
    public function showDirectorByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Director');
        $director = $repo->find($id);

        return $this->render('@MoviePortal/Director/directorById.html.twig', ['director' => $director]);
    }
    /**
     * @return Response
     * @Route("/admin/director/new/", name="new_director_form", methods={"GET"})
     */
    public function newDirectorAction()
    {
        $director = new Director();
        $form = $this->createForm('MoviePortalBundle\Form\DirectorFormType', $director);

        return $this->render('@MoviePortal/Director/directorForm.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/admin/director/new/", name="save_new_director", methods={"POST"})
     */
    public function newDirectorSaveAction(Request $request)
    {
        $director = new Director();
        $form = $this->createForm('MoviePortalBundle\Form\DirectorFormType', $director);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($director);
            $em->flush();

            return $this->redirectToRoute('show_all_directors');
        }

        return $this->redirectToRoute('new_director_form');

    }

    /**
     * @Route("/admin/director/modify/{id}/", name="modify_director_form", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function modifyDirectorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Director');
        $director = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\DirectorFormType', $director);

        return $this->render('@MoviePortal/Director/modifyDirector.html.twig', ['form' => $form->createView(), 'director'=>$director]);

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/admin/director/modify/{id}/", name="modify_director", methods={"POST"})
     * @return RedirectResponse
     */
    public function modifyDirectorSaveAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Director');
        $director = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\DirectorFormType', $director);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_all_directors');
        }

        return $this->redirectToRoute('modify_director_form');
    }

    /**
     * @Route("/admin/director/delete/{id}/", name="delete_director_form", methods={"GET"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteDirectorAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Director');
        $director = $repo->find($id);
        /** @var Movie $movie */
        foreach ($director->getMovies() as $movie) {
            $movie->removeDirector($director);
        }
        $em->remove($director);
        $em->flush();

        return $this->redirectToRoute('show_all_directors');

    }

    /**
     * @Route("/admin/director/", name="show_all_directors", methods={"GET"})
     */
    public function showAllDirectors()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Director');
        $directors = $repo->findAll();

        return $this->render('@MoviePortal/Director/showAllDirectors.html.twig', ['directors' => $directors]);

    }

    /**
     * @Route("/admin/director/find/", name="find_director", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function findDirectorAction(Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Director');
        $string = $request->get('string');
        $directors = $repo->searchDirectors($string);

        return $this->render('@MoviePortal/Director/showAllDirectors.html.twig', ['directors' => $directors]);
    }
}

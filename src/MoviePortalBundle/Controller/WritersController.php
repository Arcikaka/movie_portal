<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Movie;
use MoviePortalBundle\Entity\Writers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WritersController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/writers/{id}", methods={"GET"}, name="writer_by_id")
     */
    public function showWritersByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Writers');
        $writer = $repo->find($id);

        return $this->render('@MoviePortal/Writers/WritersById.html.twig', ['writer' => $writer]);
    }

    /**
     * @return Response
     * @Route("/admin/writers/new/", name="new_writers_form", methods={"GET"})
     */
    public function newWritersAction()
    {
        $writers = new Writers();
        $form = $this->createForm('MoviePortalBundle\Form\WritersFormType', $writers);

        return $this->render('@MoviePortal/Writers/WritersForm.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/admin/writers/new/", name="save_new_writers", methods={"POST"})
     */
    public function newWritersSaveAction(Request $request)
    {
        $writers = new Writers();
        $form = $this->createForm('MoviePortalBundle\Form\WritersFormType', $writers);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($writers);
            $em->flush();

            return $this->redirectToRoute('show_all_writers');
        }

        return $this->redirectToRoute('new_writers_form');

    }

    /**
     * @Route("/admin/writers/modify/{id}/", name="modify_writers_form", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function modifyWritersAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Writers');
        $writers = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\WritersFormType', $writers);

        return $this->render('@MoviePortal/Writers/modifyWriters.html.twig', ['form' => $form->createView(), 'writers' => $writers]);

    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/admin/writers/modify/{id}/", name="modify_writers", methods={"POST"})
     * @return RedirectResponse
     */
    public function modifyWritersSaveAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Writers');
        $writers = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\WritersFormType', $writers);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_all_writers');
        }

        return $this->redirectToRoute('modify_writers_form');
    }

    /**
     * @Route("/admin/writers/delete/{id}/", name="delete_writers_form", methods={"GET"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteWritersAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Writers');
        $writers = $repo->find($id);
        /** @var Movie $movie */
        foreach ($writers->getMovies() as $movie) {
            $movie->removeWriters($writers);
        }
        $em->remove($writers);
        $em->flush();

        return $this->redirectToRoute('show_all_writers');

    }

    /**
     * @Route("/admin/writers/", name="show_all_writers", methods={"GET"})
     */
    public function showAllWriters()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Writers');
        $writers = $repo->findAll();

        return $this->render('@MoviePortal/Writers/showAllWriters.html.twig', ['writers' => $writers]);

    }

    /**
     * @Route("/admin/writers/find/", name="find_writers", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function findWritersAction(Request $request)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Writers');
        $string = $request->get('string');
        $writers = $repo->searchWriters($string);

        return $this->render('@MoviePortal/Writers/showAllWriters.html.twig', ['writers' => $writers]);
    }
}

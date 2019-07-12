<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminPostController
 * @package MoviePortalBundle\Controller
 * @\Symfony\Component\Routing\Annotation\Route("/admin", methods={"GET"})
 */
class AdminPostController extends Controller
{
    /**
     * @Route("/create/", methods={"GET"}, name="create_post_form")
     */
    public function createFormPostAction()
    {
        $post = new Post();
        $form = $this->createForm('MoviePortalBundle\Form\PostFormType', $post);

        return $this->render('@MoviePortal/Post/PostForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/create/", methods={"POST"}, name="create_post")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createPostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = new Post();
        $form = $this->createForm('MoviePortalBundle\Form\PostFormType', $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('', ['post' => $post]);
        }
        return $this->redirectToRoute('create_post_form', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/modify/{id}/", methods={"GET"}, name="modify_post")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifyPostAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $post = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\PostFormType', $post);

        return $this->render('@MoviePortal/Post/PostForm.html.twig', ['form' => $form]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/modify/{id}/", methods={"POST"}, name="save_modify_post")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveModifyPostAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $post = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\PostFormType', $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->render('', ['post' => $post]);
        }
        return $this->render('MoviePortalBundle:Post:PostForm.html.twig', ['form' => $form]);
    }
}

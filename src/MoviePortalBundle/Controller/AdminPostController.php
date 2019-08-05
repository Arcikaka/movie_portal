<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminPostController
 * @package MoviePortalBundle\Controller
 * @Route("/admin", methods={"GET"})
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
     * @return RedirectResponse
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

            return $this->redirectToRoute('show_posts_admin', ['post' => $post]);
        }
        return $this->redirectToRoute('create_post_form', ['form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/modify/{id}/", methods={"GET"}, name="modify_post")
     * @return Response
     */
    public function modifyPostAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $post = $repo->find($id);

        $form = $this->createForm('MoviePortalBundle\Form\PostFormType', $post);

        return $this->render('@MoviePortal/Post/modifyPost.html.twig', ['form' => $form->createView(), 'post' => $post]);
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/modify/{id}/", methods={"POST"}, name="save_modify_post")
     * @return Response
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
        return $this->render('@MoviePortal/Post/modifyPost.html.twig', ['form' => $form]);
    }

    /**
     * @return Response
     * @Route("/", name="show_posts_admin")
     */
    public function showAllPostsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');

        $posts = $repo->findAll();

        return $this->render('@MoviePortal/Post/showAllPostAdmin.html.twig', ['posts' => $posts]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/delete/{id}/", methods={"GET"}, name="delete_post_id_question")
     */
    public function deletePostAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $post = $repo->find($id);

        return $this->render('@MoviePortal/Post/deletePostById.html.twig', ['post' => $post]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/delete/{id}/", name="delete_post_admin_confirmed", methods={"POST"})
     */
    public function deletePostConfirmedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $post = $repo->find($id);

        $em->remove($post);
        $em->flush();

        $posts = $repo->findAll();

        return $this->render('@MoviePortal/Post/showAllPostAdmin.html.twig',['posts' => $posts]);


    }
}

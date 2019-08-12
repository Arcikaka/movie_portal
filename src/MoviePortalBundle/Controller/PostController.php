<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends Controller
{
    /**
     * @param $id
     * @Route("/post/{id}/", name="post_by_id", methods={"GET"})
     * @return Response
     */
    public function showPostByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $post = $repo->find($id);

        return $this->render('@MoviePortal/Post/showPostById.html.twig', ['post' => $post]);
    }

    /**
     * @return Response
     * @Route("/", methods={"GET"}, name="show_all_posts")
     */
    public function showAllPostMainAction()
    {
        $offset = 0;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $posts = $repo->showAllPostLimitOffset(8, $offset);

        return $this->render('@MoviePortal/Post/showAllPosts.html.twig', ['posts' => $posts, 'offset' => $offset]);

    }

    /**
     * @Route("/{offset}/", name="show_all_posts_offset", methods={"GET"}, requirements={"offset"="\d+"})
     * @param $offset integer
     * @return Response
     */
    public function showAllPostAction($offset)
    {
        $offsetPost = (integer)$offset * 8;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $posts = $repo->showAllPostLimitOffset(8, $offsetPost);

        return $this->render('@MoviePortal/Post/showAllPosts.html.twig', ['posts' => $posts, 'offset' => $offset]);
    }

    /**
     * @Route("/admin/create/", methods={"GET"}, name="create_post_form")
     */
    public function createFormPostAction()
    {
        $post = new Post();
        $form = $this->createForm('MoviePortalBundle\Form\PostFormType', $post);

        return $this->render('@MoviePortal/Post/PostForm.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/create/", methods={"POST"}, name="create_post")
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
     * @Route("/admin/modify/{id}/", methods={"GET"}, name="modify_post")
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
     * @Route("/admin/modify/{id}/", methods={"POST"}, name="save_modify_post")
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
     * @Route("/admin/", name="show_posts_admin")
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
     * @Route("/admin/delete/{id}/", methods={"GET"}, name="delete_post_id_question")
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
     * @Route("/admin/delete/{id}/", name="delete_post_admin_confirmed", methods={"POST"})
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

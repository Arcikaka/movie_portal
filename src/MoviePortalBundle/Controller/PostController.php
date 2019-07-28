<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 * @package MoviePortalBundle\Controller
 * @Route("/", methods={"GET"})
 */
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
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $posts = $repo->showAllPostLimitOffset(8, 0);

        return $this->render('@MoviePortal/Post/showAllPosts.html.twig', ['posts' => $posts]);

    }

    /**
     * @Route("/{offset}/", name="show_all_posts_offset", methods={"GET"}, requirements={"offset" = "\d+"})
     * @param $offset
     * @return Response
     */
    public function showAllPostAction($offset)
    {
        //$offset = ($offset) * 8;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Post');
        $posts = $repo->showAllPostLimitOffset(8, $offset);

        return $this->render('@MoviePortal/Post/showAllPosts.html.twig', ['posts' => $posts]);
    }
}

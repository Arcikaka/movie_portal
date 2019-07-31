<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentsController
 * @package MoviePortalBundle\Controller
 * @Route("/comments")
 */
class CommentsController extends Controller
{
    /**
     * @param $postId
     * @param $userId
     * @Route("/new/{postId}/", name="new_form_comment", methods={"GET"})
     * @return Response
     */
    public function newFormCommentAction($postId)
    {
        return $this->render("@MoviePortal/Comment/commentForm.html.twig", ['postId' => $postId]);
    }

    /**
     * @param Request $request
     * @param $postId
     * @param $userId
     * @return RedirectResponse
     * @throws \Exception
     * @Route("/new/{postId}/", name="save_new_comment", methods={"POST"})
     */
    public function saveNewCommentAction(Request $request, $postId)
    {
        $comment = new Comments();
        $comment->setContent($request->get('content'));
        $comment->setCreatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('MoviePortalBundle:User')->find($this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $post = $em->getRepository('MoviePortalBundle:Post')->find($postId);

        $comment->setPost($post);
        $comment->setUser($this->container->get('security.token_storage')->getToken()->getUser());

        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('post_by_id', ['id' => $postId]);
    }
}

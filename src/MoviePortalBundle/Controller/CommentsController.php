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
     * @Route("/new/{postId}/{userId}/", name="new_form_comment", methods={"GET"})
     * @return Response
     */
    public function newFormCommentAction($postId, $userId)
    {
        return $this->render("@MoviePortal/Comment/commentForm.html.twig", ['postId' => $postId, 'userId' => $userId]);
    }

    /**
     * @param Request $request
     * @param $postId
     * @param $userId
     * @return RedirectResponse
     * @throws \Exception
     * @Route("/new/{postId}/{userId}/", name="save_new_comment", methods={"POST"})
     */
    public function saveNewCommentAction(Request $request, $postId, $userId)
    {
        $comment = new Comments();
        $comment->setContent($request->get('content'));
        $comment->setCreatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MoviePortalBundle:User')->find($userId);
        $post = $em->getRepository('MoviePortalBundle:Post')->find($postId);

        $comment->setPost($post);
        $comment->setUser($user);

        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('post_by_id', ['id' => $postId]);
    }
}

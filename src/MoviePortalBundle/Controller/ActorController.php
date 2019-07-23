<?php

namespace MoviePortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActorController
 * @package MoviePortalBundle\Controller
 * @Route("/actor")
 */
class ActorController extends Controller
{
    /**
     * @param $id
     * @return Response
     * @Route("/{id}/", methods={"GET"}, name="actor_by_id")
     */
    public function showActorByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MoviePortalBundle:Actor');
        $actor = $repo->find($id);

        return $this->render('@MoviePortal/Actor/ActorById.html.twig', ['actor' => $actor]);
    }
}

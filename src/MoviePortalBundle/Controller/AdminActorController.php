<?php

namespace MoviePortalBundle\Controller;

use MoviePortalBundle\Entity\Actor;
use MoviePortalBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActorController
 * @package MoviePortalBundle\Controller
 * @Route("/admin/actor")
 */
class AdminActorController extends Controller
{

/**
* @return Response
* @Route("/new/", name = "new_actor_form", methods = {"GET"})
*/
public
function newActorAction()
{
    $actor = new Actor();
    $form = $this->createForm('MoviePortalBundle\Form\ActorFormType', $actor);

    return $this->render('@MoviePortal/Actor/actorForm.html.twig', ['form' => $form->createView()]);

}

/**
 * @param Request $request
 * @return RedirectResponse
 * @Route("/new/", name="save_new_actor", methods={"POST"})
 */
public
function newActorSaveAction(Request $request)
{
    $actor = new Actor();
    $form = $this->createForm('MoviePortalBundle\Form\ActorFormType', $actor);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($actor);
        $em->flush();

        return $this->redirectToRoute('show_all_actors');
    }

    return $this->redirectToRoute('new_actor_form');

}

/**
 * @Route("/modify/{id}/", name="modify_actor_form", methods={"GET"})
 * @param $id
 * @return Response
 */
public
function modifyActorAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('MoviePortalBundle:Actor');
    $actor = $repo->find($id);

    $form = $this->createForm('MoviePortalBundle\Form\ActorFormType', $actor);

    return $this->render('@MoviePortal/Actor/modifyActor.html.twig', ['form' => $form->createView(), 'actor' => $actor]);

}

/**
 * @param Request $request
 * @param $id
 * @Route("/modify/{id}/", name="modify_actor", methods={"POST"})
 * @return RedirectResponse
 */
public
function modifyActorSaveAction(Request $request, $id)
{
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('MoviePortalBundle:Actor');
    $actor = $repo->find($id);

    $form = $this->createForm('MoviePortalBundle\Form\ActorFormType', $actor);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('show_all_actors');
    }

    return $this->redirectToRoute('modify_actor_form');
}

/**
 * @Route("/delete/{id}/", name="delete_actor_form", methods={"GET"})
 * @param $id
 * @return RedirectResponse
 */
public
function deleteActorAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('MoviePortalBundle:Actor');
    $actor = $repo->find($id);
    /** @var Movie $movie */
    foreach ($actor->getMovies() as $movie) {
        $movie->removeActors($actor);
    }
    $em->remove($actor);
    $em->flush();

    return $this->redirectToRoute('show_all_actors');

}

/**
 * @Route("/", name="show_all_actors", methods={"GET"})
 */
public
function showAllActors()
{
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('MoviePortalBundle:Actor');
    $actors = $repo->findAll();

    return $this->render('@MoviePortal/Actor/showAllActors.html.twig', ['actors' => $actors]);

}

/**
 * @Route("/find/", name="find_actor", methods={"POST"})
 * @param Request $request
 * @return Response
 */
public
function findActorAction(Request $request)
{
    $repo = $this->getDoctrine()->getManager()->getRepository('MoviePortalBundle:Actor');
    $string = $request->get('string');
    $actors = $repo->searchActors($string);

    return $this->render('@MoviePortal/Actor/showAllActors.html.twig', ['actors' => $actors]);
}
}

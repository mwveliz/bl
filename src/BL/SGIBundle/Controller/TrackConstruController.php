<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackConstru;
use BL\SGIBundle\Form\TrackConstruType;

/**
 * TrackConstru controller.
 *
 * @Route("/trackconstru")
 */
class TrackConstruController extends Controller
{
    /**
     * Lists all TrackConstru entities.
     *
     * @Route("/", name="trackconstru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trackConstrus = $em->getRepository('SGIBundle:TrackConstru')->findAll();

        return $this->render('trackconstru/index.html.twig', array(
            'trackConstrus' => $trackConstrus,
        ));
    }

    /**
     * Creates a new TrackConstru entity.
     *
     * @Route("/new", name="trackconstru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trackConstru = new TrackConstru();
        $form = $this->createForm('BL\SGIBundle\Form\TrackConstruType', $trackConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackConstru);
            $em->flush();

            return $this->redirectToRoute('trackconstru_show', array('id' => $trackconstru->getId()));
        }

        return $this->render('trackconstru/new.html.twig', array(
            'trackConstru' => $trackConstru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrackConstru entity.
     *
     * @Route("/{id}", name="trackconstru_show")
     * @Method("GET")
     */
    public function showAction(TrackConstru $trackConstru)
    {
        $deleteForm = $this->createDeleteForm($trackConstru);

        return $this->render('trackconstru/show.html.twig', array(
            'trackConstru' => $trackConstru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrackConstru entity.
     *
     * @Route("/{id}/edit", name="trackconstru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrackConstru $trackConstru)
    {
        $deleteForm = $this->createDeleteForm($trackConstru);
        $editForm = $this->createForm('BL\SGIBundle\Form\TrackConstruType', $trackConstru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackConstru);
            $em->flush();

            return $this->redirectToRoute('trackconstru_edit', array('id' => $trackConstru->getId()));
        }

        return $this->render('trackconstru/edit.html.twig', array(
            'trackConstru' => $trackConstru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrackConstru entity.
     *
     * @Route("/{id}", name="trackconstru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrackConstru $trackConstru)
    {
        $form = $this->createDeleteForm($trackConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trackConstru);
            $em->flush();
        }

        return $this->redirectToRoute('trackconstru_index');
    }

    /**
     * Creates a form to delete a TrackConstru entity.
     *
     * @param TrackConstru $trackConstru The TrackConstru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrackConstru $trackConstru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trackconstru_delete', array('id' => $trackConstru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

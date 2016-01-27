<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\TrackRental;
use BL\AppBundle\Form\TrackRentalType;

/**
 * TrackRental controller.
 *
 * @Route("/trackrental")
 */
class TrackRentalController extends Controller
{
    /**
     * Lists all TrackRental entities.
     *
     * @Route("/", name="trackrental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trackRentals = $em->getRepository('AppBundle:TrackRental')->findAll();

        return $this->render('trackrental/index.html.twig', array(
            'trackRentals' => $trackRentals,
        ));
    }

    /**
     * Creates a new TrackRental entity.
     *
     * @Route("/new", name="trackrental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trackRental = new TrackRental();
        $form = $this->createForm('BL\AppBundle\Form\TrackRentalType', $trackRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackRental);
            $em->flush();

            return $this->redirectToRoute('trackrental_show', array('id' => $trackrental->getId()));
        }

        return $this->render('trackrental/new.html.twig', array(
            'trackRental' => $trackRental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrackRental entity.
     *
     * @Route("/{id}", name="trackrental_show")
     * @Method("GET")
     */
    public function showAction(TrackRental $trackRental)
    {
        $deleteForm = $this->createDeleteForm($trackRental);

        return $this->render('trackrental/show.html.twig', array(
            'trackRental' => $trackRental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrackRental entity.
     *
     * @Route("/{id}/edit", name="trackrental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrackRental $trackRental)
    {
        $deleteForm = $this->createDeleteForm($trackRental);
        $editForm = $this->createForm('BL\AppBundle\Form\TrackRentalType', $trackRental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackRental);
            $em->flush();

            return $this->redirectToRoute('trackrental_edit', array('id' => $trackRental->getId()));
        }

        return $this->render('trackrental/edit.html.twig', array(
            'trackRental' => $trackRental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrackRental entity.
     *
     * @Route("/{id}", name="trackrental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrackRental $trackRental)
    {
        $form = $this->createDeleteForm($trackRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trackRental);
            $em->flush();
        }

        return $this->redirectToRoute('trackrental_index');
    }

    /**
     * Creates a form to delete a TrackRental entity.
     *
     * @param TrackRental $trackRental The TrackRental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrackRental $trackRental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trackrental_delete', array('id' => $trackRental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

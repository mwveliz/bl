<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\FieldsTrackRental;
use BL\AppBundle\Form\FieldsTrackRentalType;

/**
 * FieldsTrackRental controller.
 *
 * @Route("/fieldstrackrental")
 */
class FieldsTrackRentalController extends Controller
{
    /**
     * Lists all FieldsTrackRental entities.
     *
     * @Route("/", name="fieldstrackrental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsTrackRentals = $em->getRepository('AppBundle:FieldsTrackRental')->findAll();

        return $this->render('fieldstrackrental/index.html.twig', array(
            'fieldsTrackRentals' => $fieldsTrackRentals,
        ));
    }

    /**
     * Creates a new FieldsTrackRental entity.
     *
     * @Route("/new", name="fieldstrackrental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsTrackRental = new FieldsTrackRental();
        $form = $this->createForm('BL\AppBundle\Form\FieldsTrackRentalType', $fieldsTrackRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackRental);
            $em->flush();

            return $this->redirectToRoute('fieldstrackrental_show', array('id' => $fieldstrackrental->getId()));
        }

        return $this->render('fieldstrackrental/new.html.twig', array(
            'fieldsTrackRental' => $fieldsTrackRental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsTrackRental entity.
     *
     * @Route("/{id}", name="fieldstrackrental_show")
     * @Method("GET")
     */
    public function showAction(FieldsTrackRental $fieldsTrackRental)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackRental);

        return $this->render('fieldstrackrental/show.html.twig', array(
            'fieldsTrackRental' => $fieldsTrackRental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsTrackRental entity.
     *
     * @Route("/{id}/edit", name="fieldstrackrental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsTrackRental $fieldsTrackRental)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackRental);
        $editForm = $this->createForm('BL\AppBundle\Form\FieldsTrackRentalType', $fieldsTrackRental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackRental);
            $em->flush();

            return $this->redirectToRoute('fieldstrackrental_edit', array('id' => $fieldsTrackRental->getId()));
        }

        return $this->render('fieldstrackrental/edit.html.twig', array(
            'fieldsTrackRental' => $fieldsTrackRental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsTrackRental entity.
     *
     * @Route("/{id}", name="fieldstrackrental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsTrackRental $fieldsTrackRental)
    {
        $form = $this->createDeleteForm($fieldsTrackRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsTrackRental);
            $em->flush();
        }

        return $this->redirectToRoute('fieldstrackrental_index');
    }

    /**
     * Creates a form to delete a FieldsTrackRental entity.
     *
     * @param FieldsTrackRental $fieldsTrackRental The FieldsTrackRental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsTrackRental $fieldsTrackRental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldstrackrental_delete', array('id' => $fieldsTrackRental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

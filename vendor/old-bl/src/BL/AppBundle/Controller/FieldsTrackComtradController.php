<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\FieldsTrackComtrad;
use BL\AppBundle\Form\FieldsTrackComtradType;

/**
 * FieldsTrackComtrad controller.
 *
 * @Route("/fieldstrackcomtrad")
 */
class FieldsTrackComtradController extends Controller
{
    /**
     * Lists all FieldsTrackComtrad entities.
     *
     * @Route("/", name="fieldstrackcomtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsTrackComtrads = $em->getRepository('AppBundle:FieldsTrackComtrad')->findAll();

        return $this->render('fieldstrackcomtrad/index.html.twig', array(
            'fieldsTrackComtrads' => $fieldsTrackComtrads,
        ));
    }

    /**
     * Creates a new FieldsTrackComtrad entity.
     *
     * @Route("/new", name="fieldstrackcomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsTrackComtrad = new FieldsTrackComtrad();
        $form = $this->createForm('BL\AppBundle\Form\FieldsTrackComtradType', $fieldsTrackComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackComtrad);
            $em->flush();

            return $this->redirectToRoute('fieldstrackcomtrad_show', array('id' => $fieldstrackcomtrad->getId()));
        }

        return $this->render('fieldstrackcomtrad/new.html.twig', array(
            'fieldsTrackComtrad' => $fieldsTrackComtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsTrackComtrad entity.
     *
     * @Route("/{id}", name="fieldstrackcomtrad_show")
     * @Method("GET")
     */
    public function showAction(FieldsTrackComtrad $fieldsTrackComtrad)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackComtrad);

        return $this->render('fieldstrackcomtrad/show.html.twig', array(
            'fieldsTrackComtrad' => $fieldsTrackComtrad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsTrackComtrad entity.
     *
     * @Route("/{id}/edit", name="fieldstrackcomtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsTrackComtrad $fieldsTrackComtrad)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackComtrad);
        $editForm = $this->createForm('BL\AppBundle\Form\FieldsTrackComtradType', $fieldsTrackComtrad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackComtrad);
            $em->flush();

            return $this->redirectToRoute('fieldstrackcomtrad_edit', array('id' => $fieldsTrackComtrad->getId()));
        }

        return $this->render('fieldstrackcomtrad/edit.html.twig', array(
            'fieldsTrackComtrad' => $fieldsTrackComtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsTrackComtrad entity.
     *
     * @Route("/{id}", name="fieldstrackcomtrad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsTrackComtrad $fieldsTrackComtrad)
    {
        $form = $this->createDeleteForm($fieldsTrackComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsTrackComtrad);
            $em->flush();
        }

        return $this->redirectToRoute('fieldstrackcomtrad_index');
    }

    /**
     * Creates a form to delete a FieldsTrackComtrad entity.
     *
     * @param FieldsTrackComtrad $fieldsTrackComtrad The FieldsTrackComtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsTrackComtrad $fieldsTrackComtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldstrackcomtrad_delete', array('id' => $fieldsTrackComtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

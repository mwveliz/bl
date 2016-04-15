<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsTrackAltinv;
use BL\SGIBundle\Entity\FieldsAltinv;

use BL\SGIBundle\Form\FieldsTrackAltinvType;

/**
 * FieldsTrackAltinv controller.
 *
 * @Route("/fieldstrackaltinv")
 */
class FieldsTrackAltinvController extends Controller
{
    /**
     * Lists all FieldsTrackAltinv entities.
     *
     * @Route("/", name="fieldstrackaltinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsTrackAltinvs = $em->getRepository('SGIBundle:FieldsTrackAltinv')->findAll();

        return $this->render('fieldstrackaltinv/index.html.twig', array(
            'fieldsTrackAltinvs' => $fieldsTrackAltinvs,
        ));
    }
        
    /**
     * Creates a new FieldsTrackAltinv entity.
     *
     * @Route("/new", name="fieldstrackaltinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsTrackAltinv = new FieldsTrackAltinv();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsTrackAltinvType', $fieldsTrackAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackAltinv);
            $em->flush();

            return $this->redirectToRoute('fieldstrackaltinv_show', array('id' => $fieldstrackaltinv->getId()));
        }

        return $this->render('fieldstrackaltinv/new.html.twig', array(
            'fieldsTrackAltinv' => $fieldsTrackAltinv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsTrackAltinv entity.
     *
     * @Route("/{id}", name="fieldstrackaltinv_show")
     * @Method("GET")
     */
    public function showAction(FieldsTrackAltinv $fieldsTrackAltinv)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackAltinv);

        return $this->render('fieldstrackaltinv/show.html.twig', array(
            'fieldsTrackAltinv' => $fieldsTrackAltinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsTrackAltinv entity.
     *
     * @Route("/{id}/edit", name="fieldstrackaltinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsTrackAltinv $fieldsTrackAltinv)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackAltinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsTrackAltinvType', $fieldsTrackAltinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackAltinv);
            $em->flush();

            return $this->redirectToRoute('fieldstrackaltinv_edit', array('id' => $fieldsTrackAltinv->getId()));
        }

        return $this->render('fieldstrackaltinv/edit.html.twig', array(
            'fieldsTrackAltinv' => $fieldsTrackAltinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsTrackAltinv entity.
     *
     * @Route("/{id}", name="fieldstrackaltinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsTrackAltinv $fieldsTrackAltinv)
    {
        $form = $this->createDeleteForm($fieldsTrackAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsTrackAltinv);
            $em->flush();
        }

        return $this->redirectToRoute('fieldstrackaltinv_index');
    }

    /**
     * Creates a form to delete a FieldsTrackAltinv entity.
     *
     * @param FieldsTrackAltinv $fieldsTrackAltinv The FieldsTrackAltinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsTrackAltinv $fieldsTrackAltinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldstrackaltinv_delete', array('id' => $fieldsTrackAltinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

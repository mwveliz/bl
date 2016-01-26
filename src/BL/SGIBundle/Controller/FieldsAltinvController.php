<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsAltinv;
use BL\SGIBundle\Form\FieldsAltinvType;

/**
 * FieldsAltinv controller.
 *
 * @Route("/fieldsaltinv")
 */
class FieldsAltinvController extends Controller
{
    /**
     * Lists all FieldsAltinv entities.
     *
     * @Route("/", name="fieldsaltinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsAltinvs = $em->getRepository('SGIBundle:FieldsAltinv')->findAll();

        return $this->render('fieldsaltinv/index.html.twig', array(
            'fieldsAltinvs' => $fieldsAltinvs,
        ));
    }

    /**
     * Creates a new FieldsAltinv entity.
     *
     * @Route("/new", name="fieldsaltinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsAltinv = new FieldsAltinv();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsAltinvType', $fieldsAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsAltinv);
            $em->flush();

            return $this->redirectToRoute('fieldsaltinv_show', array('id' => $fieldsaltinv->getId()));
        }

        return $this->render('fieldsaltinv/new.html.twig', array(
            'fieldsAltinv' => $fieldsAltinv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsAltinv entity.
     *
     * @Route("/{id}", name="fieldsaltinv_show")
     * @Method("GET")
     */
    public function showAction(FieldsAltinv $fieldsAltinv)
    {
        $deleteForm = $this->createDeleteForm($fieldsAltinv);

        return $this->render('fieldsaltinv/show.html.twig', array(
            'fieldsAltinv' => $fieldsAltinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsAltinv entity.
     *
     * @Route("/{id}/edit", name="fieldsaltinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsAltinv $fieldsAltinv)
    {
        $deleteForm = $this->createDeleteForm($fieldsAltinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsAltinvType', $fieldsAltinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsAltinv);
            $em->flush();

            return $this->redirectToRoute('fieldsaltinv_edit', array('id' => $fieldsAltinv->getId()));
        }

        return $this->render('fieldsaltinv/edit.html.twig', array(
            'fieldsAltinv' => $fieldsAltinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsAltinv entity.
     *
     * @Route("/{id}", name="fieldsaltinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsAltinv $fieldsAltinv)
    {
        $form = $this->createDeleteForm($fieldsAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsAltinv);
            $em->flush();
        }

        return $this->redirectToRoute('fieldsaltinv_index');
    }

    /**
     * Creates a form to delete a FieldsAltinv entity.
     *
     * @param FieldsAltinv $fieldsAltinv The FieldsAltinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsAltinv $fieldsAltinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldsaltinv_delete', array('id' => $fieldsAltinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

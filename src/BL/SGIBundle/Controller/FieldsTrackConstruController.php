<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsTrackConstru;
use BL\SGIBundle\Form\FieldsTrackConstruType;

/**
 * FieldsTrackConstru controller.
 *
 * @Route("/fieldstrackconstru")
 */
class FieldsTrackConstruController extends Controller
{
    /**
     * Lists all FieldsTrackConstru entities.
     *
     * @Route("/", name="fieldstrackconstru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsTrackConstrus = $em->getRepository('SGIBundle:FieldsTrackConstru')->findAll();

        return $this->render('fieldstrackconstru/index.html.twig', array(
            'fieldsTrackConstrus' => $fieldsTrackConstrus,
        ));
    }

    /**
     * Creates a new FieldsTrackConstru entity.
     *
     * @Route("/new", name="fieldstrackconstru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsTrackConstru = new FieldsTrackConstru();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsTrackConstruType', $fieldsTrackConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackConstru);
            $em->flush();

            return $this->redirectToRoute('fieldstrackconstru_show', array('id' => $fieldstrackconstru->getId()));
        }

        return $this->render('fieldstrackconstru/new.html.twig', array(
            'fieldsTrackConstru' => $fieldsTrackConstru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsTrackConstru entity.
     *
     * @Route("/{id}", name="fieldstrackconstru_show")
     * @Method("GET")
     */
    public function showAction(FieldsTrackConstru $fieldsTrackConstru)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackConstru);

        return $this->render('fieldstrackconstru/show.html.twig', array(
            'fieldsTrackConstru' => $fieldsTrackConstru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsTrackConstru entity.
     *
     * @Route("/{id}/edit", name="fieldstrackconstru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsTrackConstru $fieldsTrackConstru)
    {
        $deleteForm = $this->createDeleteForm($fieldsTrackConstru);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsTrackConstruType', $fieldsTrackConstru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsTrackConstru);
            $em->flush();

            return $this->redirectToRoute('fieldstrackconstru_edit', array('id' => $fieldsTrackConstru->getId()));
        }

        return $this->render('fieldstrackconstru/edit.html.twig', array(
            'fieldsTrackConstru' => $fieldsTrackConstru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsTrackConstru entity.
     *
     * @Route("/{id}", name="fieldstrackconstru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsTrackConstru $fieldsTrackConstru)
    {
        $form = $this->createDeleteForm($fieldsTrackConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsTrackConstru);
            $em->flush();
        }

        return $this->redirectToRoute('fieldstrackconstru_index');
    }

    /**
     * Creates a form to delete a FieldsTrackConstru entity.
     *
     * @param FieldsTrackConstru $fieldsTrackConstru The FieldsTrackConstru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsTrackConstru $fieldsTrackConstru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldstrackconstru_delete', array('id' => $fieldsTrackConstru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

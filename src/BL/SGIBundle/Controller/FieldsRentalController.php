<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsRental;
use BL\SGIBundle\Form\FieldsRentalType;

/**
 * FieldsRental controller.
 *
 * @Route("/fieldsrental")
 */
class FieldsRentalController extends Controller
{
    /**
     * Lists all FieldsRental entities.
     *
     * @Route("/", name="fieldsrental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsRentals = $em->getRepository('SGIBundle:FieldsRental')->findAll();

        return $this->render('fieldsrental/index.html.twig', array(
            'fieldsRentals' => $fieldsRentals,
        ));
    }

    /**
     * Creates a new FieldsRental entity.
     *
     * @Route("/new", name="fieldsrental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsRental = new FieldsRental();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsRentalType', $fieldsRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsRental);
            $em->flush();

            return $this->redirectToRoute('fieldsrental_show', array('id' => $fieldsrental->getId()));
        }

        return $this->render('fieldsrental/new.html.twig', array(
            'fieldsRental' => $fieldsRental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsRental entity.
     *
     * @Route("/{id}", name="fieldsrental_show")
     * @Method("GET")
     */
    public function showAction(FieldsRental $fieldsRental)
    {
        $deleteForm = $this->createDeleteForm($fieldsRental);

        return $this->render('fieldsrental/show.html.twig', array(
            'fieldsRental' => $fieldsRental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsRental entity.
     *
     * @Route("/{id}/edit", name="fieldsrental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsRental $fieldsRental)
    {
        $deleteForm = $this->createDeleteForm($fieldsRental);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsRentalType', $fieldsRental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsRental);
            $em->flush();

            return $this->redirectToRoute('fieldsrental_edit', array('id' => $fieldsRental->getId()));
        }

        return $this->render('fieldsrental/edit.html.twig', array(
            'fieldsRental' => $fieldsRental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsRental entity.
     *
     * @Route("/{id}", name="fieldsrental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsRental $fieldsRental)
    {
        $form = $this->createDeleteForm($fieldsRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsRental);
            $em->flush();
        }

        return $this->redirectToRoute('fieldsrental_index');
    }

    /**
     * Creates a form to delete a FieldsRental entity.
     *
     * @param FieldsRental $fieldsRental The FieldsRental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsRental $fieldsRental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldsrental_delete', array('id' => $fieldsRental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

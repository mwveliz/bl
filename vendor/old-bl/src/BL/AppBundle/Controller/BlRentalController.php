<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\BlRental;
use BL\AppBundle\Form\BlRentalType;

/**
 * BlRental controller.
 *
 * @Route("/blrental")
 */
class BlRentalController extends Controller
{
    /**
     * Lists all BlRental entities.
     *
     * @Route("/", name="blrental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blRentals = $em->getRepository('AppBundle:BlRental')->findAll();

        return $this->render('blrental/index.html.twig', array(
            'blRentals' => $blRentals,
        ));
    }

    /**
     * Creates a new BlRental entity.
     *
     * @Route("/new", name="blrental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blRental = new BlRental();
        $form = $this->createForm('BL\AppBundle\Form\BlRentalType', $blRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blRental);
            $em->flush();

            return $this->redirectToRoute('blrental_show', array('id' => $blrental->getId()));
        }

        return $this->render('blrental/new.html.twig', array(
            'blRental' => $blRental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlRental entity.
     *
     * @Route("/{id}", name="blrental_show")
     * @Method("GET")
     */
    public function showAction(BlRental $blRental)
    {
        $deleteForm = $this->createDeleteForm($blRental);

        return $this->render('blrental/show.html.twig', array(
            'blRental' => $blRental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlRental entity.
     *
     * @Route("/{id}/edit", name="blrental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlRental $blRental)
    {
        $deleteForm = $this->createDeleteForm($blRental);
        $editForm = $this->createForm('BL\AppBundle\Form\BlRentalType', $blRental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blRental);
            $em->flush();

            return $this->redirectToRoute('blrental_edit', array('id' => $blRental->getId()));
        }

        return $this->render('blrental/edit.html.twig', array(
            'blRental' => $blRental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlRental entity.
     *
     * @Route("/{id}", name="blrental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlRental $blRental)
    {
        $form = $this->createDeleteForm($blRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blRental);
            $em->flush();
        }

        return $this->redirectToRoute('blrental_index');
    }

    /**
     * Creates a form to delete a BlRental entity.
     *
     * @param BlRental $blRental The BlRental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlRental $blRental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blrental_delete', array('id' => $blRental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

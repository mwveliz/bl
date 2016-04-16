<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\BlSeller;
use BL\SGIBundle\Form\BlSellerType;

/**
 * BlSeller controller.
 *
 * @Route("/blseller")
 */
class BlSellerController extends Controller
{
    /**
     * Lists all BlSeller entities.
     *
     * @Route("/", name="blseller_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blSellers = $em->getRepository('SGIBundle:BlSeller')->findAll();

        return $this->render('blseller/index.html.twig', array(
            'blSellers' => $blSellers,
        ));
    }

    /**
     * Creates a new BlSeller entity.
     *
     * @Route("/new", name="blseller_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blSeller = new BlSeller();
        $form = $this->createForm('BL\SGIBundle\Form\BlSellerType', $blSeller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blSeller);
            $em->flush();

            return $this->redirectToRoute('blseller_show', array('id' => $blseller->getId()));
        }

        return $this->render('blseller/new.html.twig', array(
            'blSeller' => $blSeller,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlSeller entity.
     *
     * @Route("/{id}", name="blseller_show")
     * @Method("GET")
     */
    public function showAction(BlSeller $blSeller)
    {
        $deleteForm = $this->createDeleteForm($blSeller);

        return $this->render('blseller/show.html.twig', array(
            'blSeller' => $blSeller,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlSeller entity.
     *
     * @Route("/{id}/edit", name="blseller_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlSeller $blSeller)
    {
        $deleteForm = $this->createDeleteForm($blSeller);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlSellerType', $blSeller);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blSeller);
            $em->flush();

            return $this->redirectToRoute('blseller_edit', array('id' => $blSeller->getId()));
        }

        return $this->render('blseller/edit.html.twig', array(
            'blSeller' => $blSeller,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlSeller entity.
     *
     * @Route("/{id}", name="blseller_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlSeller $blSeller)
    {
        $form = $this->createDeleteForm($blSeller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blSeller);
            $em->flush();
        }

        return $this->redirectToRoute('blseller_index');
    }

    /**
     * Creates a form to delete a BlSeller entity.
     *
     * @param BlSeller $blSeller The BlSeller entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlSeller $blSeller)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blseller_delete', array('id' => $blSeller->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

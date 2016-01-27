<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\Billing;
use BL\AppBundle\Form\BillingType;

/**
 * Billing controller.
 *
 * @Route("/billing")
 */
class BillingController extends Controller
{
    /**
     * Lists all Billing entities.
     *
     * @Route("/", name="billing_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $billings = $em->getRepository('AppBundle:Billing')->findAll();

        return $this->render('billing/index.html.twig', array(
            'billings' => $billings,
        ));
    }

    /**
     * Creates a new Billing entity.
     *
     * @Route("/new", name="billing_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $billing = new Billing();
        $form = $this->createForm('BL\AppBundle\Form\BillingType', $billing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($billing);
            $em->flush();

            return $this->redirectToRoute('billing_show', array('id' => $billing->getId()));
        }

        return $this->render('billing/new.html.twig', array(
            'billing' => $billing,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Billing entity.
     *
     * @Route("/{id}", name="billing_show")
     * @Method("GET")
     */
    public function showAction(Billing $billing)
    {
        $deleteForm = $this->createDeleteForm($billing);

        return $this->render('billing/show.html.twig', array(
            'billing' => $billing,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Billing entity.
     *
     * @Route("/{id}/edit", name="billing_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Billing $billing)
    {
        $deleteForm = $this->createDeleteForm($billing);
        $editForm = $this->createForm('BL\AppBundle\Form\BillingType', $billing);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($billing);
            $em->flush();

            return $this->redirectToRoute('billing_edit', array('id' => $billing->getId()));
        }

        return $this->render('billing/edit.html.twig', array(
            'billing' => $billing,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Billing entity.
     *
     * @Route("/{id}", name="billing_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Billing $billing)
    {
        $form = $this->createDeleteForm($billing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($billing);
            $em->flush();
        }

        return $this->redirectToRoute('billing_index');
    }

    /**
     * Creates a form to delete a Billing entity.
     *
     * @param Billing $billing The Billing entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Billing $billing)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('billing_delete', array('id' => $billing->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

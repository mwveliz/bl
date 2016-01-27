<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\BillingDetail;
use BL\AppBundle\Form\BillingDetailType;

/**
 * BillingDetail controller.
 *
 * @Route("/billingdetail")
 */
class BillingDetailController extends Controller
{
    /**
     * Lists all BillingDetail entities.
     *
     * @Route("/", name="billingdetail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $billingDetails = $em->getRepository('AppBundle:BillingDetail')->findAll();

        return $this->render('billingdetail/index.html.twig', array(
            'billingDetails' => $billingDetails,
        ));
    }

    /**
     * Creates a new BillingDetail entity.
     *
     * @Route("/new", name="billingdetail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $billingDetail = new BillingDetail();
        $form = $this->createForm('BL\AppBundle\Form\BillingDetailType', $billingDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($billingDetail);
            $em->flush();

            return $this->redirectToRoute('billingdetail_show', array('id' => $billingdetail->getId()));
        }

        return $this->render('billingdetail/new.html.twig', array(
            'billingDetail' => $billingDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BillingDetail entity.
     *
     * @Route("/{id}", name="billingdetail_show")
     * @Method("GET")
     */
    public function showAction(BillingDetail $billingDetail)
    {
        $deleteForm = $this->createDeleteForm($billingDetail);

        return $this->render('billingdetail/show.html.twig', array(
            'billingDetail' => $billingDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BillingDetail entity.
     *
     * @Route("/{id}/edit", name="billingdetail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BillingDetail $billingDetail)
    {
        $deleteForm = $this->createDeleteForm($billingDetail);
        $editForm = $this->createForm('BL\AppBundle\Form\BillingDetailType', $billingDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($billingDetail);
            $em->flush();

            return $this->redirectToRoute('billingdetail_edit', array('id' => $billingDetail->getId()));
        }

        return $this->render('billingdetail/edit.html.twig', array(
            'billingDetail' => $billingDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BillingDetail entity.
     *
     * @Route("/{id}", name="billingdetail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BillingDetail $billingDetail)
    {
        $form = $this->createDeleteForm($billingDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($billingDetail);
            $em->flush();
        }

        return $this->redirectToRoute('billingdetail_index');
    }

    /**
     * Creates a form to delete a BillingDetail entity.
     *
     * @param BillingDetail $billingDetail The BillingDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BillingDetail $billingDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('billingdetail_delete', array('id' => $billingDetail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

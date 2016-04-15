<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\DashboardPosition;
use BL\SGIBundle\Form\DashboardPositionType;

/**
 * DashboardPosition controller.
 *
 * @Route("/dashboardposition")
 */
class DashboardPositionController extends Controller
{
    /**
     * Lists all DashboardPosition entities.
     *
     * @Route("/", name="dashboardposition_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dashboardPositions = $em->getRepository('SGIBundle:DashboardPosition')->findAll();

        return $this->render('dashboardposition/index.html.twig', array(
            'dashboardPositions' => $dashboardPositions,
        ));
    }

    /**
     * Creates a new DashboardPosition entity.
     *
     * @Route("/new", name="dashboardposition_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dashboardPosition = new DashboardPosition();
        $form = $this->createForm('BL\SGIBundle\Form\DashboardPositionType', $dashboardPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboardPosition);
            $em->flush();

            return $this->redirectToRoute('dashboardposition_show', array('id' => $dashboardposition->getId()));
        }

        return $this->render('dashboardposition/new.html.twig', array(
            'dashboardPosition' => $dashboardPosition,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DashboardPosition entity.
     *
     * @Route("/{id}", name="dashboardposition_show")
     * @Method("GET")
     */
    public function showAction(DashboardPosition $dashboardPosition)
    {
        $deleteForm = $this->createDeleteForm($dashboardPosition);

        return $this->render('dashboardposition/show.html.twig', array(
            'dashboardPosition' => $dashboardPosition,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DashboardPosition entity.
     *
     * @Route("/{id}/edit", name="dashboardposition_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DashboardPosition $dashboardPosition)
    {
        $deleteForm = $this->createDeleteForm($dashboardPosition);
        $editForm = $this->createForm('BL\SGIBundle\Form\DashboardPositionType', $dashboardPosition);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboardPosition);
            $em->flush();

            return $this->redirectToRoute('dashboardposition_edit', array('id' => $dashboardPosition->getId()));
        }

        return $this->render('dashboardposition/edit.html.twig', array(
            'dashboardPosition' => $dashboardPosition,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DashboardPosition entity.
     *
     * @Route("/{id}", name="dashboardposition_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DashboardPosition $dashboardPosition)
    {
        $form = $this->createDeleteForm($dashboardPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dashboardPosition);
            $em->flush();
        }

        return $this->redirectToRoute('dashboardposition_index');
    }

    /**
     * Creates a form to delete a DashboardPosition entity.
     *
     * @param DashboardPosition $dashboardPosition The DashboardPosition entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DashboardPosition $dashboardPosition)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dashboardposition_delete', array('id' => $dashboardPosition->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

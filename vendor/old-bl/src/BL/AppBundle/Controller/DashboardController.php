<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\Dashboard;
use BL\AppBundle\Form\DashboardType;

/**
 * Dashboard controller.
 *
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
    /**
     * Lists all Dashboard entities.
     *
     * @Route("/", name="dashboard_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dashboards = $em->getRepository('AppBundle:Dashboard')->findAll();

        return $this->render('dashboard/index.html.twig', array(
            'dashboards' => $dashboards,
        ));
    }

    /**
     * Creates a new Dashboard entity.
     *
     * @Route("/new", name="dashboard_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dashboard = new Dashboard();
        $form = $this->createForm('BL\AppBundle\Form\DashboardType', $dashboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboard);
            $em->flush();

            return $this->redirectToRoute('dashboard_show', array('id' => $dashboard->getId()));
        }

        return $this->render('dashboard/new.html.twig', array(
            'dashboard' => $dashboard,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Dashboard entity.
     *
     * @Route("/{id}", name="dashboard_show")
     * @Method("GET")
     */
    public function showAction(Dashboard $dashboard)
    {
        $deleteForm = $this->createDeleteForm($dashboard);

        return $this->render('dashboard/show.html.twig', array(
            'dashboard' => $dashboard,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dashboard entity.
     *
     * @Route("/{id}/edit", name="dashboard_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dashboard $dashboard)
    {
        $deleteForm = $this->createDeleteForm($dashboard);
        $editForm = $this->createForm('BL\AppBundle\Form\DashboardType', $dashboard);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboard);
            $em->flush();

            return $this->redirectToRoute('dashboard_edit', array('id' => $dashboard->getId()));
        }

        return $this->render('dashboard/edit.html.twig', array(
            'dashboard' => $dashboard,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dashboard entity.
     *
     * @Route("/{id}", name="dashboard_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dashboard $dashboard)
    {
        $form = $this->createDeleteForm($dashboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dashboard);
            $em->flush();
        }

        return $this->redirectToRoute('dashboard_index');
    }

    /**
     * Creates a form to delete a Dashboard entity.
     *
     * @param Dashboard $dashboard The Dashboard entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dashboard $dashboard)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dashboard_delete', array('id' => $dashboard->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

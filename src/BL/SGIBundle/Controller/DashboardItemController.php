<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\DashboardItem;
use BL\SGIBundle\Form\DashboardItemType;

/**
 * DashboardItem controller.
 *
 * @Route("/dashboarditem")
 */
class DashboardItemController extends Controller
{
    /**
     * Lists all DashboardItem entities.
     *
     * @Route("/", name="dashboarditem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dashboardItems = $em->getRepository('SGIBundle:DashboardItem')->findAll();

        return $this->render('dashboarditem/index.html.twig', array(
            'dashboardItems' => $dashboardItems,
        ));
    }

    /**
     * Creates a new DashboardItem entity.
     *
     * @Route("/new", name="dashboarditem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dashboardItem = new DashboardItem();
        $form = $this->createForm('BL\SGIBundle\Form\DashboardItemType', $dashboardItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboardItem);
            $em->flush();

            return $this->redirectToRoute('dashboarditem_show', array('id' => $dashboarditem->getId()));
        }

        return $this->render('dashboarditem/new.html.twig', array(
            'dashboardItem' => $dashboardItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DashboardItem entity.
     *
     * @Route("/{id}", name="dashboarditem_show")
     * @Method("GET")
     */
    public function showAction(DashboardItem $dashboardItem)
    {
        $deleteForm = $this->createDeleteForm($dashboardItem);

        return $this->render('dashboarditem/show.html.twig', array(
            'dashboardItem' => $dashboardItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DashboardItem entity.
     *
     * @Route("/{id}/edit", name="dashboarditem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DashboardItem $dashboardItem)
    {
        $deleteForm = $this->createDeleteForm($dashboardItem);
        $editForm = $this->createForm('BL\SGIBundle\Form\DashboardItemType', $dashboardItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboardItem);
            $em->flush();

            return $this->redirectToRoute('dashboarditem_edit', array('id' => $dashboardItem->getId()));
        }

        return $this->render('dashboarditem/edit.html.twig', array(
            'dashboardItem' => $dashboardItem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DashboardItem entity.
     *
     * @Route("/{id}", name="dashboarditem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DashboardItem $dashboardItem)
    {
        $form = $this->createDeleteForm($dashboardItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dashboardItem);
            $em->flush();
        }

        return $this->redirectToRoute('dashboarditem_index');
    }

    /**
     * Creates a form to delete a DashboardItem entity.
     *
     * @param DashboardItem $dashboardItem The DashboardItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DashboardItem $dashboardItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dashboarditem_delete', array('id' => $dashboardItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

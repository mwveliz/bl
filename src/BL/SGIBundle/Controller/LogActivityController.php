<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\LogActivity;
use BL\SGIBundle\Form\LogActivityType;

/**
 * LogActivity controller.
 *
 * @Route("/logactivity")
 */
class LogActivityController extends Controller
{
    /**
     * Lists all LogActivity entities.
     *
     * @Route("/", name="logactivity_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $logActivities = $em->getRepository('SGIBundle:LogActivity')->findAll();

        return $this->render('logactivity/index.html.twig', array(
            'logActivities' => $logActivities,
        ));
    }

    /**
     * Creates a new LogActivity entity.
     *
     * @Route("/new", name="logactivity_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $logActivity = new LogActivity();
        $form = $this->createForm('BL\SGIBundle\Form\LogActivityType', $logActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logActivity);
            $em->flush();

            return $this->redirectToRoute('logactivity_show', array('id' => $logactivity->getId()));
        }

        return $this->render('logactivity/new.html.twig', array(
            'logActivity' => $logActivity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LogActivity entity.
     *
     * @Route("/{id}", name="logactivity_show")
     * @Method("GET")
     */
    public function showAction(LogActivity $logActivity)
    {
        $deleteForm = $this->createDeleteForm($logActivity);

        return $this->render('logactivity/show.html.twig', array(
            'logActivity' => $logActivity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LogActivity entity.
     *
     * @Route("/{id}/edit", name="logactivity_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LogActivity $logActivity)
    {
        $deleteForm = $this->createDeleteForm($logActivity);
        $editForm = $this->createForm('BL\SGIBundle\Form\LogActivityType', $logActivity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logActivity);
            $em->flush();

            return $this->redirectToRoute('logactivity_edit', array('id' => $logActivity->getId()));
        }

        return $this->render('logactivity/edit.html.twig', array(
            'logActivity' => $logActivity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LogActivity entity.
     *
     * @Route("/{id}", name="logactivity_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LogActivity $logActivity)
    {
        $form = $this->createDeleteForm($logActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($logActivity);
            $em->flush();
        }

        return $this->redirectToRoute('logactivity_index');
    }

    /**
     * Creates a form to delete a LogActivity entity.
     *
     * @param LogActivity $logActivity The LogActivity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LogActivity $logActivity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logactivity_delete', array('id' => $logActivity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

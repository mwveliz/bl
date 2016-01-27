<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\LogMessage;
use BL\SGIBundle\Form\LogMessageType;

/**
 * LogMessage controller.
 *
 * @Route("/logmessage")
 */
class LogMessageController extends Controller
{
    /**
     * Lists all LogMessage entities.
     *
     * @Route("/", name="logmessage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $logMessages = $em->getRepository('SGIBundle:LogMessage')->findAll();

        return $this->render('logmessage/index.html.twig', array(
            'logMessages' => $logMessages,
        ));
    }

    /**
     * Creates a new LogMessage entity.
     *
     * @Route("/new", name="logmessage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $logMessage = new LogMessage();
        $form = $this->createForm('BL\SGIBundle\Form\LogMessageType', $logMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logMessage);
            $em->flush();

            return $this->redirectToRoute('logmessage_show', array('id' => $logmessage->getId()));
        }

        return $this->render('logmessage/new.html.twig', array(
            'logMessage' => $logMessage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LogMessage entity.
     *
     * @Route("/{id}", name="logmessage_show")
     * @Method("GET")
     */
    public function showAction(LogMessage $logMessage)
    {
        $deleteForm = $this->createDeleteForm($logMessage);

        return $this->render('logmessage/show.html.twig', array(
            'logMessage' => $logMessage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LogMessage entity.
     *
     * @Route("/{id}/edit", name="logmessage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LogMessage $logMessage)
    {
        $deleteForm = $this->createDeleteForm($logMessage);
        $editForm = $this->createForm('BL\SGIBundle\Form\LogMessageType', $logMessage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logMessage);
            $em->flush();

            return $this->redirectToRoute('logmessage_edit', array('id' => $logMessage->getId()));
        }

        return $this->render('logmessage/edit.html.twig', array(
            'logMessage' => $logMessage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LogMessage entity.
     *
     * @Route("/{id}", name="logmessage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LogMessage $logMessage)
    {
        $form = $this->createDeleteForm($logMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($logMessage);
            $em->flush();
        }

        return $this->redirectToRoute('logmessage_index');
    }

    /**
     * Creates a form to delete a LogMessage entity.
     *
     * @param LogMessage $logMessage The LogMessage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LogMessage $logMessage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logmessage_delete', array('id' => $logMessage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

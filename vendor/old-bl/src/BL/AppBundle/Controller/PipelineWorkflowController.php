<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\PipelineWorkflow;
use BL\AppBundle\Form\PipelineWorkflowType;

/**
 * PipelineWorkflow controller.
 *
 * @Route("/pipelineworkflow")
 */
class PipelineWorkflowController extends Controller
{
    /**
     * Lists all PipelineWorkflow entities.
     *
     * @Route("/", name="pipelineworkflow_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pipelineWorkflows = $em->getRepository('AppBundle:PipelineWorkflow')->findAll();

        return $this->render('pipelineworkflow/index.html.twig', array(
            'pipelineWorkflows' => $pipelineWorkflows,
        ));
    }

    /**
     * Creates a new PipelineWorkflow entity.
     *
     * @Route("/new", name="pipelineworkflow_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pipelineWorkflow = new PipelineWorkflow();
        $form = $this->createForm('BL\AppBundle\Form\PipelineWorkflowType', $pipelineWorkflow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pipelineWorkflow);
            $em->flush();

            return $this->redirectToRoute('pipelineworkflow_show', array('id' => $pipelineworkflow->getId()));
        }

        return $this->render('pipelineworkflow/new.html.twig', array(
            'pipelineWorkflow' => $pipelineWorkflow,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PipelineWorkflow entity.
     *
     * @Route("/{id}", name="pipelineworkflow_show")
     * @Method("GET")
     */
    public function showAction(PipelineWorkflow $pipelineWorkflow)
    {
        $deleteForm = $this->createDeleteForm($pipelineWorkflow);

        return $this->render('pipelineworkflow/show.html.twig', array(
            'pipelineWorkflow' => $pipelineWorkflow,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PipelineWorkflow entity.
     *
     * @Route("/{id}/edit", name="pipelineworkflow_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PipelineWorkflow $pipelineWorkflow)
    {
        $deleteForm = $this->createDeleteForm($pipelineWorkflow);
        $editForm = $this->createForm('BL\AppBundle\Form\PipelineWorkflowType', $pipelineWorkflow);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pipelineWorkflow);
            $em->flush();

            return $this->redirectToRoute('pipelineworkflow_edit', array('id' => $pipelineWorkflow->getId()));
        }

        return $this->render('pipelineworkflow/edit.html.twig', array(
            'pipelineWorkflow' => $pipelineWorkflow,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PipelineWorkflow entity.
     *
     * @Route("/{id}", name="pipelineworkflow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PipelineWorkflow $pipelineWorkflow)
    {
        $form = $this->createDeleteForm($pipelineWorkflow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pipelineWorkflow);
            $em->flush();
        }

        return $this->redirectToRoute('pipelineworkflow_index');
    }

    /**
     * Creates a form to delete a PipelineWorkflow entity.
     *
     * @param PipelineWorkflow $pipelineWorkflow The PipelineWorkflow entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PipelineWorkflow $pipelineWorkflow)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pipelineworkflow_delete', array('id' => $pipelineWorkflow->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

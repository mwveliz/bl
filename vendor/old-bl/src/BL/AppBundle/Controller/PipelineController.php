<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\Pipeline;
use BL\AppBundle\Form\PipelineType;

/**
 * Pipeline controller.
 *
 * @Route("/pipeline")
 */
class PipelineController extends Controller
{
    /**
     * Lists all Pipeline entities.
     *
     * @Route("/", name="pipeline_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pipelines = $em->getRepository('AppBundle:Pipeline')->findAll();

        return $this->render('pipeline/index.html.twig', array(
            'pipelines' => $pipelines,
        ));
    }

    /**
     * Creates a new Pipeline entity.
     *
     * @Route("/new", name="pipeline_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pipeline = new Pipeline();
        $form = $this->createForm('BL\AppBundle\Form\PipelineType', $pipeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pipeline);
            $em->flush();

            return $this->redirectToRoute('pipeline_show', array('id' => $pipeline->getId()));
        }

        return $this->render('pipeline/new.html.twig', array(
            'pipeline' => $pipeline,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pipeline entity.
     *
     * @Route("/{id}", name="pipeline_show")
     * @Method("GET")
     */
    public function showAction(Pipeline $pipeline)
    {
        $deleteForm = $this->createDeleteForm($pipeline);

        return $this->render('pipeline/show.html.twig', array(
            'pipeline' => $pipeline,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pipeline entity.
     *
     * @Route("/{id}/edit", name="pipeline_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pipeline $pipeline)
    {
        $deleteForm = $this->createDeleteForm($pipeline);
        $editForm = $this->createForm('BL\AppBundle\Form\PipelineType', $pipeline);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pipeline);
            $em->flush();

            return $this->redirectToRoute('pipeline_edit', array('id' => $pipeline->getId()));
        }

        return $this->render('pipeline/edit.html.twig', array(
            'pipeline' => $pipeline,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pipeline entity.
     *
     * @Route("/{id}", name="pipeline_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pipeline $pipeline)
    {
        $form = $this->createDeleteForm($pipeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pipeline);
            $em->flush();
        }

        return $this->redirectToRoute('pipeline_index');
    }

    /**
     * Creates a form to delete a Pipeline entity.
     *
     * @param Pipeline $pipeline The Pipeline entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pipeline $pipeline)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pipeline_delete', array('id' => $pipeline->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

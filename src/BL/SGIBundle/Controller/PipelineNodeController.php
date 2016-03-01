<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\PipelineNode;
use BL\SGIBundle\Form\PipelineNodeType;

/**
 * PipelineNode controller.
 *
 * @Route("/pipelinenode")
 */
class PipelineNodeController extends Controller
{
    /**
     * Lists all PipelineNode entities.
     *
     * @Route("/", name="pipelinenode_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pipelineNodes = $em->getRepository('SGIBundle:PipelineNode')->findAll();

        return $this->render('pipelinenode/index.html.twig', array(
            'pipelineNodes' => $pipelineNodes,
        ));
    }

    /**
     * Creates a new PipelineNode entity.
     *
     * @Route("/new", name="pipelinenode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pipelineNode = new PipelineNode();
        $form = $this->createForm('BL\SGIBundle\Form\PipelineNodeType', $pipelineNode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pipelineNode);
            $em->flush();

            return $this->redirectToRoute('pipelinenode_show', array('id' => $pipelinenode->getId()));
        }

        return $this->render('pipelinenode/new.html.twig', array(
            'pipelineNode' => $pipelineNode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PipelineNode entity.
     *
     * @Route("/{id}", name="pipelinenode_show")
     * @Method("GET")
     */
    public function showAction(PipelineNode $pipelineNode)
    {
        $deleteForm = $this->createDeleteForm($pipelineNode);

        return $this->render('pipelinenode/show.html.twig', array(
            'pipelineNode' => $pipelineNode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PipelineNode entity.
     *
     * @Route("/{id}/edit", name="pipelinenode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PipelineNode $pipelineNode)
    {
        $deleteForm = $this->createDeleteForm($pipelineNode);
        $editForm = $this->createForm('BL\SGIBundle\Form\PipelineNodeType', $pipelineNode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pipelineNode);
            $em->flush();

            return $this->redirectToRoute('pipelinenode_edit', array('id' => $pipelineNode->getId()));
        }

        return $this->render('pipelinenode/edit.html.twig', array(
            'pipelineNode' => $pipelineNode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PipelineNode entity.
     *
     * @Route("/{id}", name="pipelinenode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PipelineNode $pipelineNode)
    {
        $form = $this->createDeleteForm($pipelineNode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pipelineNode);
            $em->flush();
        }

        return $this->redirectToRoute('pipelinenode_index');
    }

    /**
     * Creates a form to delete a PipelineNode entity.
     *
     * @param PipelineNode $pipelineNode The PipelineNode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PipelineNode $pipelineNode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pipelinenode_delete', array('id' => $pipelineNode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

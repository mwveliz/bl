<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Altinv;
use BL\SGIBundle\Form\AltinvType;

/**
 * Altinv controller.
 *
 * @Route("/altinv")
 */
class AltinvController extends Controller
{
    /**
     * Lists all Altinv entities.
     *
     * @Route("/", name="altinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $altinvs = $em->getRepository('SGIBundle:Altinv')->findAll();

        return $this->render('altinv/index.html.twig', array(
            'altinvs' => $altinvs,
        ));
    }

    /**
     * Creates a new Altinv entity.
     *
     * @Route("/new", name="altinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $altinv = new Altinv();
        $form = $this->createForm('BL\SGIBundle\Form\AltinvType', $altinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($altinv);
            $em->flush();

            return $this->redirectToRoute('altinv_show', array('id' => $altinv->getId()));
        }

        return $this->render('altinv/new.html.twig', array(
            'altinv' => $altinv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Altinv entity.
     *
     * @Route("/{id}", name="altinv_show")
     * @Method("GET")
     */
    public function showAction(Altinv $altinv)
    {
        $deleteForm = $this->createDeleteForm($altinv);

        return $this->render('altinv/show.html.twig', array(
            'altinv' => $altinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Altinv entity.
     *
     * @Route("/{id}/edit", name="altinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Altinv $altinv)
    {
        $deleteForm = $this->createDeleteForm($altinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\AltinvType', $altinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($altinv);
            $em->flush();

            return $this->redirectToRoute('altinv_edit', array('id' => $altinv->getId()));
        }

        return $this->render('altinv/edit.html.twig', array(
            'altinv' => $altinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Altinv entity.
     *
     * @Route("/{id}", name="altinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Altinv $altinv)
    {
        $form = $this->createDeleteForm($altinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($altinv);
            $em->flush();
        }

        return $this->redirectToRoute('altinv_index');
    }

    /**
     * Creates a form to delete a Altinv entity.
     *
     * @param Altinv $altinv The Altinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Altinv $altinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('altinv_delete', array('id' => $altinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

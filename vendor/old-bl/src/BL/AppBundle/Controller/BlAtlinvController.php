<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\BlAtlinv;
use BL\AppBundle\Form\BlAtlinvType;

/**
 * BlAtlinv controller.
 *
 * @Route("/blatlinv")
 */
class BlAtlinvController extends Controller
{
    /**
     * Lists all BlAtlinv entities.
     *
     * @Route("/", name="blatlinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blAtlinvs = $em->getRepository('AppBundle:BlAtlinv')->findAll();

        return $this->render('blatlinv/index.html.twig', array(
            'blAtlinvs' => $blAtlinvs,
        ));
    }

    /**
     * Creates a new BlAtlinv entity.
     *
     * @Route("/new", name="blatlinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blAtlinv = new BlAtlinv();
        $form = $this->createForm('BL\AppBundle\Form\BlAtlinvType', $blAtlinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blAtlinv);
            $em->flush();

            return $this->redirectToRoute('blatlinv_show', array('id' => $blatlinv->getId()));
        }

        return $this->render('blatlinv/new.html.twig', array(
            'blAtlinv' => $blAtlinv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlAtlinv entity.
     *
     * @Route("/{id}", name="blatlinv_show")
     * @Method("GET")
     */
    public function showAction(BlAtlinv $blAtlinv)
    {
        $deleteForm = $this->createDeleteForm($blAtlinv);

        return $this->render('blatlinv/show.html.twig', array(
            'blAtlinv' => $blAtlinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlAtlinv entity.
     *
     * @Route("/{id}/edit", name="blatlinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlAtlinv $blAtlinv)
    {
        $deleteForm = $this->createDeleteForm($blAtlinv);
        $editForm = $this->createForm('BL\AppBundle\Form\BlAtlinvType', $blAtlinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blAtlinv);
            $em->flush();

            return $this->redirectToRoute('blatlinv_edit', array('id' => $blAtlinv->getId()));
        }

        return $this->render('blatlinv/edit.html.twig', array(
            'blAtlinv' => $blAtlinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlAtlinv entity.
     *
     * @Route("/{id}", name="blatlinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlAtlinv $blAtlinv)
    {
        $form = $this->createDeleteForm($blAtlinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blAtlinv);
            $em->flush();
        }

        return $this->redirectToRoute('blatlinv_index');
    }

    /**
     * Creates a form to delete a BlAtlinv entity.
     *
     * @param BlAtlinv $blAtlinv The BlAtlinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlAtlinv $blAtlinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blatlinv_delete', array('id' => $blAtlinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

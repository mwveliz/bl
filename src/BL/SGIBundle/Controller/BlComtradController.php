<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\BlComtrad;
use BL\SGIBundle\Form\BlComtradType;

/**
 * BlComtrad controller.
 *
 * @Route("/blcomtrad")
 */
class BlComtradController extends Controller
{
    /**
     * Lists all BlComtrad entities.
     *
     * @Route("/", name="blcomtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blComtrads = $em->getRepository('SGIBundle:BlComtrad')->findAll();

        return $this->render('blcomtrad/index.html.twig', array(
            'blComtrads' => $blComtrads,
        ));
    }

    /**
     * Creates a new BlComtrad entity.
     *
     * @Route("/new", name="blcomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blComtrad = new BlComtrad();
        $form = $this->createForm('BL\SGIBundle\Form\BlComtradType', $blComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blComtrad);
            $em->flush();

            return $this->redirectToRoute('blcomtrad_show', array('id' => $blcomtrad->getId()));
        }

        return $this->render('blcomtrad/new.html.twig', array(
            'blComtrad' => $blComtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlComtrad entity.
     *
     * @Route("/{id}", name="blcomtrad_show")
     * @Method("GET")
     */
    public function showAction(BlComtrad $blComtrad)
    {
        $deleteForm = $this->createDeleteForm($blComtrad);

        return $this->render('blcomtrad/show.html.twig', array(
            'blComtrad' => $blComtrad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlComtrad entity.
     *
     * @Route("/{id}/edit", name="blcomtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlComtrad $blComtrad)
    {
        $deleteForm = $this->createDeleteForm($blComtrad);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlComtradType', $blComtrad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blComtrad);
            $em->flush();

            return $this->redirectToRoute('blcomtrad_edit', array('id' => $blComtrad->getId()));
        }

        return $this->render('blcomtrad/edit.html.twig', array(
            'blComtrad' => $blComtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlComtrad entity.
     *
     * @Route("/{id}", name="blcomtrad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlComtrad $blComtrad)
    {
        $form = $this->createDeleteForm($blComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blComtrad);
            $em->flush();
        }

        return $this->redirectToRoute('blcomtrad_index');
    }

    /**
     * Creates a form to delete a BlComtrad entity.
     *
     * @param BlComtrad $blComtrad The BlComtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlComtrad $blComtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blcomtrad_delete', array('id' => $blComtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

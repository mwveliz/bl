<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Bl;
use BL\SGIBundle\Form\BlType;

/**
 * Bl controller.
 *
 * @Route("/bl")
 */
class BlController extends Controller
{
    /**
     * Lists all Bl entities.
     *
     * @Route("/", name="bl_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bls = $em->getRepository('SGIBundle:Bl')->findAll();

        return $this->render('bl/index.html.twig', array(
            'bls' => $bls,
        ));
    }

    /**
     * Creates a new Bl entity.
     *
     * @Route("/new", name="bl_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bl = new Bl();
        $form = $this->createForm('BL\SGIBundle\Form\BlType', $bl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();

            return $this->redirectToRoute('bl_show', array('id' => $bl->getId()));
        }

        return $this->render('bl/new.html.twig', array(
            'bl' => $bl,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bl entity.
     *
     * @Route("/{id}", name="bl_show")
     * @Method("GET")
     */
    public function showAction(Bl $bl)
    {
        $deleteForm = $this->createDeleteForm($bl);

        return $this->render('bl/show.html.twig', array(
            'bl' => $bl,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Bl entity.
     *
     * @Route("/{id}/edit", name="bl_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bl $bl)
    {
        $deleteForm = $this->createDeleteForm($bl);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlType', $bl);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();

            return $this->redirectToRoute('bl_edit', array('id' => $bl->getId()));
        }

        return $this->render('bl/edit.html.twig', array(
            'bl' => $bl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bl entity.
     *
     * @Route("/{id}", name="bl_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bl $bl)
    {
        $form = $this->createDeleteForm($bl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bl);
            $em->flush();
        }

        return $this->redirectToRoute('bl_index');
    }

    /**
     * Creates a form to delete a Bl entity.
     *
     * @param Bl $bl The Bl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bl $bl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bl_delete', array('id' => $bl->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

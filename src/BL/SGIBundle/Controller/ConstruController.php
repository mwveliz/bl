<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Constru;
use BL\SGIBundle\Form\ConstruType;

/**
 * Constru controller.
 *
 * @Route("/constru")
 */
class ConstruController extends Controller
{
    /**
     * Lists all Constru entities.
     *
     * @Route("/", name="constru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $construs = $em->getRepository('SGIBundle:Constru')->findAll();

        return $this->render('constru/index.html.twig', array(
            'construs' => $construs,
        ));
    }

    /**
     * Creates a new Constru entity.
     *
     * @Route("/new", name="constru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $constru = new Constru();
        $form = $this->createForm('BL\SGIBundle\Form\ConstruType', $constru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($constru);
            $em->flush();

            return $this->redirectToRoute('constru_show', array('id' => $constru->getId()));
        }

        return $this->render('constru/new.html.twig', array(
            'constru' => $constru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Constru entity.
     *
     * @Route("/{id}", name="constru_show")
     * @Method("GET")
     */
    public function showAction(Constru $constru)
    {
        $deleteForm = $this->createDeleteForm($constru);

        return $this->render('constru/show.html.twig', array(
            'constru' => $constru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Constru entity.
     *
     * @Route("/{id}/edit", name="constru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Constru $constru)
    {
        $deleteForm = $this->createDeleteForm($constru);
        $editForm = $this->createForm('BL\SGIBundle\Form\ConstruType', $constru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($constru);
            $em->flush();

            return $this->redirectToRoute('constru_edit', array('id' => $constru->getId()));
        }

        return $this->render('constru/edit.html.twig', array(
            'constru' => $constru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Constru entity.
     *
     * @Route("/{id}", name="constru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Constru $constru)
    {
        $form = $this->createDeleteForm($constru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($constru);
            $em->flush();
        }

        return $this->redirectToRoute('constru_index');
    }

    /**
     * Creates a form to delete a Constru entity.
     *
     * @param Constru $constru The Constru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Constru $constru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('constru_delete', array('id' => $constru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

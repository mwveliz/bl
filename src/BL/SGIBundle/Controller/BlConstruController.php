<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\BlConstru;
use BL\SGIBundle\Form\BlConstruType;

/**
 * BlConstru controller.
 *
 * @Route("/blconstru")
 */
class BlConstruController extends Controller
{
    /**
     * Lists all BlConstru entities.
     *
     * @Route("/", name="blconstru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blConstrus = $em->getRepository('SGIBundle:BlConstru')->findAll();

        return $this->render('blconstru/index.html.twig', array(
            'blConstrus' => $blConstrus,
        ));
    }

    /**
     * Creates a new BlConstru entity.
     *
     * @Route("/new", name="blconstru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blConstru = new BlConstru();
        $form = $this->createForm('BL\SGIBundle\Form\BlConstruType', $blConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blConstru);
            $em->flush();

            return $this->redirectToRoute('blconstru_show', array('id' => $blconstru->getId()));
        }

        return $this->render('blconstru/new.html.twig', array(
            'blConstru' => $blConstru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlConstru entity.
     *
     * @Route("/{id}", name="blconstru_show")
     * @Method("GET")
     */
    public function showAction(BlConstru $blConstru)
    {
        $deleteForm = $this->createDeleteForm($blConstru);

        return $this->render('blconstru/show.html.twig', array(
            'blConstru' => $blConstru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlConstru entity.
     *
     * @Route("/{id}/edit", name="blconstru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlConstru $blConstru)
    {
        $deleteForm = $this->createDeleteForm($blConstru);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlConstruType', $blConstru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blConstru);
            $em->flush();

            return $this->redirectToRoute('blconstru_edit', array('id' => $blConstru->getId()));
        }

        return $this->render('blconstru/edit.html.twig', array(
            'blConstru' => $blConstru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlConstru entity.
     *
     * @Route("/{id}", name="blconstru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlConstru $blConstru)
    {
        $form = $this->createDeleteForm($blConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blConstru);
            $em->flush();
        }

        return $this->redirectToRoute('blconstru_index');
    }

    /**
     * Creates a form to delete a BlConstru entity.
     *
     * @param BlConstru $blConstru The BlConstru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlConstru $blConstru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blconstru_delete', array('id' => $blConstru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

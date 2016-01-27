<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\TypeComtrad;
use BL\AppBundle\Form\TypeComtradType;

/**
 * TypeComtrad controller.
 *
 * @Route("/typecomtrad")
 */
class TypeComtradController extends Controller
{
    /**
     * Lists all TypeComtrad entities.
     *
     * @Route("/", name="typecomtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeComtrads = $em->getRepository('AppBundle:TypeComtrad')->findAll();

        return $this->render('typecomtrad/index.html.twig', array(
            'typeComtrads' => $typeComtrads,
        ));
    }

    /**
     * Creates a new TypeComtrad entity.
     *
     * @Route("/new", name="typecomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeComtrad = new TypeComtrad();
        $form = $this->createForm('BL\AppBundle\Form\TypeComtradType', $typeComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeComtrad);
            $em->flush();

            return $this->redirectToRoute('typecomtrad_show', array('id' => $typecomtrad->getId()));
        }

        return $this->render('typecomtrad/new.html.twig', array(
            'typeComtrad' => $typeComtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeComtrad entity.
     *
     * @Route("/{id}", name="typecomtrad_show")
     * @Method("GET")
     */
    public function showAction(TypeComtrad $typeComtrad)
    {
        $deleteForm = $this->createDeleteForm($typeComtrad);

        return $this->render('typecomtrad/show.html.twig', array(
            'typeComtrad' => $typeComtrad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeComtrad entity.
     *
     * @Route("/{id}/edit", name="typecomtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeComtrad $typeComtrad)
    {
        $deleteForm = $this->createDeleteForm($typeComtrad);
        $editForm = $this->createForm('BL\AppBundle\Form\TypeComtradType', $typeComtrad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeComtrad);
            $em->flush();

            return $this->redirectToRoute('typecomtrad_edit', array('id' => $typeComtrad->getId()));
        }

        return $this->render('typecomtrad/edit.html.twig', array(
            'typeComtrad' => $typeComtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeComtrad entity.
     *
     * @Route("/{id}", name="typecomtrad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeComtrad $typeComtrad)
    {
        $form = $this->createDeleteForm($typeComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeComtrad);
            $em->flush();
        }

        return $this->redirectToRoute('typecomtrad_index');
    }

    /**
     * Creates a form to delete a TypeComtrad entity.
     *
     * @param TypeComtrad $typeComtrad The TypeComtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeComtrad $typeComtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typecomtrad_delete', array('id' => $typeComtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TypeAltinv;
use BL\SGIBundle\Form\TypeAltinvType;

/**
 * TypeAltinv controller.
 *
 * @Route("/typealtinv")
 */
class TypeAltinvController extends Controller
{
    /**
     * Lists all TypeAltinv entities.
     *
     * @Route("/", name="typealtinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeAltinvs = $em->getRepository('SGIBundle:TypeAltinv')->findAll();

        return $this->render('typealtinv/index.html.twig', array(
            'typeAltinvs' => $typeAltinvs,
        ));
    }

    /**
     * Creates a new TypeAltinv entity.
     *
     * @Route("/new", name="typealtinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ruta='typealtinv/new.html.twig';
        $typeAltinv = new TypeAltinv();
        $form = $this->createForm('BL\SGIBundle\Form\TypeAltinvType', $typeAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeAltinv);
            $em->flush();

            return $this->redirectToRoute('typealtinv_show', array('id' => $typealtinv->getId()));
        }


        if ($request->isXmlHttpRequest()) $ruta='typealtinv/ajax_new.html.twig'; //si es por ajhax cargo el twig

        return $this->render($ruta, array(
            'typeAltinv' => $typeAltinv,
            'form' => $form->createView(),
        ));



    }

    /**
     * Finds and displays a TypeAltinv entity.
     *
     * @Route("/{id}", name="typealtinv_show")
     * @Method("GET")
     */
    public function showAction(TypeAltinv $typeAltinv)
    {
        $deleteForm = $this->createDeleteForm($typeAltinv);

        return $this->render('typealtinv/show.html.twig', array(
            'typeAltinv' => $typeAltinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeAltinv entity.
     *
     * @Route("/{id}/edit", name="typealtinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeAltinv $typeAltinv)
    {
        $deleteForm = $this->createDeleteForm($typeAltinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\TypeAltinvType', $typeAltinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeAltinv);
            $em->flush();

            return $this->redirectToRoute('typealtinv_edit', array('id' => $typeAltinv->getId()));
        }

        return $this->render('typealtinv/edit.html.twig', array(
            'typeAltinv' => $typeAltinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeAltinv entity.
     *
     * @Route("/{id}", name="typealtinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeAltinv $typeAltinv)
    {
        $form = $this->createDeleteForm($typeAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeAltinv);
            $em->flush();
        }

        return $this->redirectToRoute('typealtinv_index');
    }

    /**
     * Creates a form to delete a TypeAltinv entity.
     *
     * @param TypeAltinv $typeAltinv The TypeAltinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeAltinv $typeAltinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typealtinv_delete', array('id' => $typeAltinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

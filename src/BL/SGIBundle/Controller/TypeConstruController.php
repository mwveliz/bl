<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TypeConstru;
use BL\SGIBundle\Form\TypeConstruType;

/**
 * TypeConstru controller.
 *
 * @Route("/typeconstru")
 */
class TypeConstruController extends Controller
{
    /**
     * Lists all TypeConstru entities.
     *
     * @Route("/", name="typeconstru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeConstrus = $em->getRepository('SGIBundle:TypeConstru')->findAll();

        return $this->render('typeconstru/index.html.twig', array(
            'typeConstrus' => $typeConstrus,
        ));
    }

    /**
     * Creates a new TypeConstru entity.
     *
     * @Route("/new", name="typeconstru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeConstru = new TypeConstru();
        $form = $this->createForm('BL\SGIBundle\Form\TypeConstruType', $typeConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeConstru);
            $em->flush();

            return $this->redirectToRoute('typeconstru_show', array('id' => $typeconstru->getId()));
        }

        return $this->render('typeconstru/new.html.twig', array(
            'typeConstru' => $typeConstru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeConstru entity.
     *
     * @Route("/{id}", name="typeconstru_show")
     * @Method("GET")
     */
    public function showAction(TypeConstru $typeConstru)
    {
        $deleteForm = $this->createDeleteForm($typeConstru);

        return $this->render('typeconstru/show.html.twig', array(
            'typeConstru' => $typeConstru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeConstru entity.
     *
     * @Route("/{id}/edit", name="typeconstru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeConstru $typeConstru)
    {
        $deleteForm = $this->createDeleteForm($typeConstru);
        $editForm = $this->createForm('BL\SGIBundle\Form\TypeConstruType', $typeConstru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeConstru);
            $em->flush();

            return $this->redirectToRoute('typeconstru_edit', array('id' => $typeConstru->getId()));
        }

        return $this->render('typeconstru/edit.html.twig', array(
            'typeConstru' => $typeConstru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeConstru entity.
     *
     * @Route("/{id}", name="typeconstru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeConstru $typeConstru)
    {
        $form = $this->createDeleteForm($typeConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeConstru);
            $em->flush();
        }

        return $this->redirectToRoute('typeconstru_index');
    }

    /**
     * Creates a form to delete a TypeConstru entity.
     *
     * @param TypeConstru $typeConstru The TypeConstru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeConstru $typeConstru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeconstru_delete', array('id' => $typeConstru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\FosUser;
use BL\AppBundle\Form\FosUserType;

/**
 * FosUser controller.
 *
 * @Route("/fosuser")
 */
class FosUserController extends Controller
{
    /**
     * Lists all FosUser entities.
     *
     * @Route("/", name="fosuser_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fosUsers = $em->getRepository('AppBundle:FosUser')->findAll();

        return $this->render('fosuser/index.html.twig', array(
            'fosUsers' => $fosUsers,
        ));
    }

    /**
     * Creates a new FosUser entity.
     *
     * @Route("/new", name="fosuser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fosUser = new FosUser();
        $form = $this->createForm('BL\AppBundle\Form\FosUserType', $fosUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fosUser);
            $em->flush();

            return $this->redirectToRoute('fosuser_show', array('id' => $fosuser->getId()));
        }

        return $this->render('fosuser/new.html.twig', array(
            'fosUser' => $fosUser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FosUser entity.
     *
     * @Route("/{id}", name="fosuser_show")
     * @Method("GET")
     */
    public function showAction(FosUser $fosUser)
    {
        $deleteForm = $this->createDeleteForm($fosUser);

        return $this->render('fosuser/show.html.twig', array(
            'fosUser' => $fosUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FosUser entity.
     *
     * @Route("/{id}/edit", name="fosuser_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FosUser $fosUser)
    {
        $deleteForm = $this->createDeleteForm($fosUser);
        $editForm = $this->createForm('BL\AppBundle\Form\FosUserType', $fosUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fosUser);
            $em->flush();

            return $this->redirectToRoute('fosuser_edit', array('id' => $fosUser->getId()));
        }

        return $this->render('fosuser/edit.html.twig', array(
            'fosUser' => $fosUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FosUser entity.
     *
     * @Route("/{id}", name="fosuser_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FosUser $fosUser)
    {
        $form = $this->createDeleteForm($fosUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fosUser);
            $em->flush();
        }

        return $this->redirectToRoute('fosuser_index');
    }

    /**
     * Creates a form to delete a FosUser entity.
     *
     * @param FosUser $fosUser The FosUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FosUser $fosUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fosuser_delete', array('id' => $fosUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

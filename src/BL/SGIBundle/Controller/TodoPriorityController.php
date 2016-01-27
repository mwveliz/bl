<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TodoPriority;
use BL\SGIBundle\Form\TodoPriorityType;

/**
 * TodoPriority controller.
 *
 * @Route("/todopriority")
 */
class TodoPriorityController extends Controller
{
    /**
     * Lists all TodoPriority entities.
     *
     * @Route("/", name="todopriority_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $todoPriorities = $em->getRepository('SGIBundle:TodoPriority')->findAll();

        return $this->render('todopriority/index.html.twig', array(
            'todoPriorities' => $todoPriorities,
        ));
    }

    /**
     * Creates a new TodoPriority entity.
     *
     * @Route("/new", name="todopriority_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $todoPriority = new TodoPriority();
        $form = $this->createForm('BL\SGIBundle\Form\TodoPriorityType', $todoPriority);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($todoPriority);
            $em->flush();

            return $this->redirectToRoute('todopriority_show', array('id' => $todopriority->getId()));
        }

        return $this->render('todopriority/new.html.twig', array(
            'todoPriority' => $todoPriority,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TodoPriority entity.
     *
     * @Route("/{id}", name="todopriority_show")
     * @Method("GET")
     */
    public function showAction(TodoPriority $todoPriority)
    {
        $deleteForm = $this->createDeleteForm($todoPriority);

        return $this->render('todopriority/show.html.twig', array(
            'todoPriority' => $todoPriority,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TodoPriority entity.
     *
     * @Route("/{id}/edit", name="todopriority_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TodoPriority $todoPriority)
    {
        $deleteForm = $this->createDeleteForm($todoPriority);
        $editForm = $this->createForm('BL\SGIBundle\Form\TodoPriorityType', $todoPriority);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($todoPriority);
            $em->flush();

            return $this->redirectToRoute('todopriority_edit', array('id' => $todoPriority->getId()));
        }

        return $this->render('todopriority/edit.html.twig', array(
            'todoPriority' => $todoPriority,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TodoPriority entity.
     *
     * @Route("/{id}", name="todopriority_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TodoPriority $todoPriority)
    {
        $form = $this->createDeleteForm($todoPriority);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($todoPriority);
            $em->flush();
        }

        return $this->redirectToRoute('todopriority_index');
    }

    /**
     * Creates a form to delete a TodoPriority entity.
     *
     * @param TodoPriority $todoPriority The TodoPriority entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TodoPriority $todoPriority)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('todopriority_delete', array('id' => $todoPriority->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

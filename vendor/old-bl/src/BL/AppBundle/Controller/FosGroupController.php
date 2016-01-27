<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\FosGroup;
use BL\AppBundle\Form\FosGroupType;

/**
 * FosGroup controller.
 *
 * @Route("/fosgroup")
 */
class FosGroupController extends Controller
{
    /**
     * Lists all FosGroup entities.
     *
     * @Route("/", name="fosgroup_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fosGroups = $em->getRepository('AppBundle:FosGroup')->findAll();

        return $this->render('fosgroup/index.html.twig', array(
            'fosGroups' => $fosGroups,
        ));
    }

    /**
     * Creates a new FosGroup entity.
     *
     * @Route("/new", name="fosgroup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fosGroup = new FosGroup();
        $form = $this->createForm('BL\AppBundle\Form\FosGroupType', $fosGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fosGroup);
            $em->flush();

            return $this->redirectToRoute('fosgroup_show', array('id' => $fosgroup->getId()));
        }

        return $this->render('fosgroup/new.html.twig', array(
            'fosGroup' => $fosGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FosGroup entity.
     *
     * @Route("/{id}", name="fosgroup_show")
     * @Method("GET")
     */
    public function showAction(FosGroup $fosGroup)
    {
        $deleteForm = $this->createDeleteForm($fosGroup);

        return $this->render('fosgroup/show.html.twig', array(
            'fosGroup' => $fosGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FosGroup entity.
     *
     * @Route("/{id}/edit", name="fosgroup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FosGroup $fosGroup)
    {
        $deleteForm = $this->createDeleteForm($fosGroup);
        $editForm = $this->createForm('BL\AppBundle\Form\FosGroupType', $fosGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fosGroup);
            $em->flush();

            return $this->redirectToRoute('fosgroup_edit', array('id' => $fosGroup->getId()));
        }

        return $this->render('fosgroup/edit.html.twig', array(
            'fosGroup' => $fosGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FosGroup entity.
     *
     * @Route("/{id}", name="fosgroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FosGroup $fosGroup)
    {
        $form = $this->createDeleteForm($fosGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fosGroup);
            $em->flush();
        }

        return $this->redirectToRoute('fosgroup_index');
    }

    /**
     * Creates a form to delete a FosGroup entity.
     *
     * @param FosGroup $fosGroup The FosGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FosGroup $fosGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fosgroup_delete', array('id' => $fosGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

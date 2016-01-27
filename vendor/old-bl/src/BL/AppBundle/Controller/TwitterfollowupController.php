<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\Twitterfollowup;
use BL\AppBundle\Form\TwitterfollowupType;

/**
 * Twitterfollowup controller.
 *
 * @Route("/twitterfollowup")
 */
class TwitterfollowupController extends Controller
{
    /**
     * Lists all Twitterfollowup entities.
     *
     * @Route("/", name="twitterfollowup_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $twitterfollowups = $em->getRepository('AppBundle:Twitterfollowup')->findAll();

        return $this->render('twitterfollowup/index.html.twig', array(
            'twitterfollowups' => $twitterfollowups,
        ));
    }

    /**
     * Creates a new Twitterfollowup entity.
     *
     * @Route("/new", name="twitterfollowup_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $twitterfollowup = new Twitterfollowup();
        $form = $this->createForm('BL\AppBundle\Form\TwitterfollowupType', $twitterfollowup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($twitterfollowup);
            $em->flush();

            return $this->redirectToRoute('twitterfollowup_show', array('id' => $twitterfollowup->getId()));
        }

        return $this->render('twitterfollowup/new.html.twig', array(
            'twitterfollowup' => $twitterfollowup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Twitterfollowup entity.
     *
     * @Route("/{id}", name="twitterfollowup_show")
     * @Method("GET")
     */
    public function showAction(Twitterfollowup $twitterfollowup)
    {
        $deleteForm = $this->createDeleteForm($twitterfollowup);

        return $this->render('twitterfollowup/show.html.twig', array(
            'twitterfollowup' => $twitterfollowup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Twitterfollowup entity.
     *
     * @Route("/{id}/edit", name="twitterfollowup_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Twitterfollowup $twitterfollowup)
    {
        $deleteForm = $this->createDeleteForm($twitterfollowup);
        $editForm = $this->createForm('BL\AppBundle\Form\TwitterfollowupType', $twitterfollowup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($twitterfollowup);
            $em->flush();

            return $this->redirectToRoute('twitterfollowup_edit', array('id' => $twitterfollowup->getId()));
        }

        return $this->render('twitterfollowup/edit.html.twig', array(
            'twitterfollowup' => $twitterfollowup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Twitterfollowup entity.
     *
     * @Route("/{id}", name="twitterfollowup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Twitterfollowup $twitterfollowup)
    {
        $form = $this->createDeleteForm($twitterfollowup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($twitterfollowup);
            $em->flush();
        }

        return $this->redirectToRoute('twitterfollowup_index');
    }

    /**
     * Creates a form to delete a Twitterfollowup entity.
     *
     * @param Twitterfollowup $twitterfollowup The Twitterfollowup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Twitterfollowup $twitterfollowup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('twitterfollowup_delete', array('id' => $twitterfollowup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

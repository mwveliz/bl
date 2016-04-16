<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\BlClient;
use BL\SGIBundle\Form\BlClientType;

/**
 * BlClient controller.
 *
 * @Route("/blclient")
 */
class BlClientController extends Controller
{
    /**
     * Lists all BlClient entities.
     *
     * @Route("/", name="blclient_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blClients = $em->getRepository('SGIBundle:BlClient')->findAll();

        return $this->render('blclient/index.html.twig', array(
            'blClients' => $blClients,
        ));
    }

    /**
     * Creates a new BlClient entity.
     *
     * @Route("/new", name="blclient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blClient = new BlClient();
        $form = $this->createForm('BL\SGIBundle\Form\BlClientType', $blClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blClient);
            $em->flush();

            return $this->redirectToRoute('blclient_show', array('id' => $blclient->getId()));
        }

        return $this->render('blclient/new.html.twig', array(
            'blClient' => $blClient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlClient entity.
     *
     * @Route("/{id}", name="blclient_show")
     * @Method("GET")
     */
    public function showAction(BlClient $blClient)
    {
        $deleteForm = $this->createDeleteForm($blClient);

        return $this->render('blclient/show.html.twig', array(
            'blClient' => $blClient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlClient entity.
     *
     * @Route("/{id}/edit", name="blclient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlClient $blClient)
    {
        $deleteForm = $this->createDeleteForm($blClient);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlClientType', $blClient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blClient);
            $em->flush();

            return $this->redirectToRoute('blclient_edit', array('id' => $blClient->getId()));
        }

        return $this->render('blclient/edit.html.twig', array(
            'blClient' => $blClient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlClient entity.
     *
     * @Route("/{id}", name="blclient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlClient $blClient)
    {
        $form = $this->createDeleteForm($blClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blClient);
            $em->flush();
        }

        return $this->redirectToRoute('blclient_index');
    }

    /**
     * Creates a form to delete a BlClient entity.
     *
     * @param BlClient $blClient The BlClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlClient $blClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blclient_delete', array('id' => $blClient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

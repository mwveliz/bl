<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsClient;
use BL\SGIBundle\Form\FieldsClientType;

/**
 * FieldsClient controller.
 *
 * @Route("/fieldsclient")
 */
class FieldsClientController extends Controller
{
    /**
     * Lists all FieldsClient entities.
     *
     * @Route("/", name="fieldsclient_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsClients = $em->getRepository('SGIBundle:FieldsClient')->findAll();

        return $this->render('fieldsclient/index.html.twig', array(
            'fieldsClients' => $fieldsClients,
        ));
    }

    /**
     * Creates a new FieldsClient entity.
     *
     * @Route("/new", name="fieldsclient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsClient = new FieldsClient();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsClientType', $fieldsClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsClient);
            $em->flush();

            return $this->redirectToRoute('fieldsclient_show', array('id' => $fieldsclient->getId()));
        }

        return $this->render('fieldsclient/new.html.twig', array(
            'fieldsClient' => $fieldsClient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsClient entity.
     *
     * @Route("/{id}", name="fieldsclient_show")
     * @Method("GET")
     */
    public function showAction(FieldsClient $fieldsClient)
    {
        $deleteForm = $this->createDeleteForm($fieldsClient);

        return $this->render('fieldsclient/show.html.twig', array(
            'fieldsClient' => $fieldsClient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsClient entity.
     *
     * @Route("/{id}/edit", name="fieldsclient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsClient $fieldsClient)
    {
        $deleteForm = $this->createDeleteForm($fieldsClient);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsClientType', $fieldsClient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsClient);
            $em->flush();

            return $this->redirectToRoute('fieldsclient_edit', array('id' => $fieldsClient->getId()));
        }

        return $this->render('fieldsclient/edit.html.twig', array(
            'fieldsClient' => $fieldsClient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsClient entity.
     *
     * @Route("/{id}", name="fieldsclient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsClient $fieldsClient)
    {
        $form = $this->createDeleteForm($fieldsClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsClient);
            $em->flush();
        }

        return $this->redirectToRoute('fieldsclient_index');
    }

    /**
     * Creates a form to delete a FieldsClient entity.
     *
     * @param FieldsClient $fieldsClient The FieldsClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsClient $fieldsClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldsclient_delete', array('id' => $fieldsClient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

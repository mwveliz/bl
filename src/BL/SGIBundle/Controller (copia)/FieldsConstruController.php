<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsConstru;
use BL\SGIBundle\Form\FieldsConstruType;

/**
 * FieldsConstru controller.
 *
 * @Route("/fieldsconstru")
 */
class FieldsConstruController extends Controller
{
    /**
     * Lists all FieldsConstru entities.
     *
     * @Route("/", name="fieldsconstru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsConstrus = $em->getRepository('SGIBundle:FieldsConstru')->findAll();

        return $this->render('fieldsconstru/index.html.twig', array(
            'fieldsConstrus' => $fieldsConstrus,
        ));
    }
 /**
     * Create Constru Fields entities via ajax.
     *
     * @Route("/add", name="ajax_fieldsconstru_create")
     * @Method("POST")
     */
    public function ajaxCreateFieldsConstru(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new FieldsConstru();
        $object->setDescription( $request->get('description') );
        $object->setWidget($request->get('widget') );
        $object->setTrackable(false);
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }
    
    
    /**
     * Remove Constru Fields entities from form via ajax.
     *
     * @Route("/remo", name="ajax_fieldsconstru_remove")
     * @Method("POST")
     */
    public function ajaxRemoveFieldsConstru(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new FieldsConstru();
        $object->setDescription( $request->get('description') );
        $object->setWidget($request->get('widget') );
        $object->setTrackable($request->get('trackable') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }
    /**
     * Creates a new FieldsConstru entity.
     *
     * @Route("/new", name="fieldsconstru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ruta='fieldsconstru/new.html.twig';
        $fieldsConstru = new FieldsConstru();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsConstruType', $fieldsConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsConstru);
            $em->flush();

            return $this->redirectToRoute('fieldsconstru_show', array('id' => $fieldsConstru->getId()));
        }
if ($request->isXmlHttpRequest()) $ruta='fieldsconstru/ajax_new.html.twig'; //si es por ajhax cargo el twig
        return $this->render($ruta, array(
            'fieldsConstru' => $fieldsConstru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsConstru entity.
     *
     * @Route("/{id}", name="fieldsconstru_show")
     * @Method("GET")
     */
    public function showAction(FieldsConstru $fieldsConstru)
    {
        $deleteForm = $this->createDeleteForm($fieldsConstru);

        return $this->render('fieldsconstru/show.html.twig', array(
            'fieldsConstru' => $fieldsConstru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsConstru entity.
     *
     * @Route("/{id}/edit", name="fieldsconstru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsConstru $fieldsConstru)
    {
        $deleteForm = $this->createDeleteForm($fieldsConstru);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsConstruType', $fieldsConstru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsConstru);
            $em->flush();

            return $this->redirectToRoute('fieldsconstru_edit', array('id' => $fieldsConstru->getId()));
        }

        return $this->render('fieldsconstru/edit.html.twig', array(
            'fieldsConstru' => $fieldsConstru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsConstru entity.
     *
     * @Route("/{id}", name="fieldsconstru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FieldsConstru $fieldsConstru)
    {
        $form = $this->createDeleteForm($fieldsConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fieldsConstru);
            $em->flush();
        }

        return $this->redirectToRoute('fieldsconstru_index');
    }

    /**
     * Creates a form to delete a FieldsConstru entity.
     *
     * @param FieldsConstru $fieldsConstru The FieldsConstru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsConstru $fieldsConstru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldsconstru_delete', array('id' => $fieldsConstru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace BL\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\AppBundle\Entity\Tenant;
use BL\AppBundle\Form\TenantType;

/**
 * Tenant controller.
 *
 * @Route("/tenant")
 */
class TenantController extends Controller
{
    /**
     * Lists all Tenant entities.
     *
     * @Route("/", name="tenant_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tenants = $em->getRepository('AppBundle:Tenant')->findAll();

        return $this->render('tenant/index.html.twig', array(
            'tenants' => $tenants,
        ));
    }

    /**
     * Creates a new Tenant entity.
     *
     * @Route("/new", name="tenant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tenant = new Tenant();
        $form = $this->createForm('BL\AppBundle\Form\TenantType', $tenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tenant);
            $em->flush();

            return $this->redirectToRoute('tenant_show', array('id' => $tenant->getId()));
        }

        return $this->render('tenant/new.html.twig', array(
            'tenant' => $tenant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tenant entity.
     *
     * @Route("/{id}", name="tenant_show")
     * @Method("GET")
     */
    public function showAction(Tenant $tenant)
    {
        $deleteForm = $this->createDeleteForm($tenant);

        return $this->render('tenant/show.html.twig', array(
            'tenant' => $tenant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tenant entity.
     *
     * @Route("/{id}/edit", name="tenant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tenant $tenant)
    {
        $deleteForm = $this->createDeleteForm($tenant);
        $editForm = $this->createForm('BL\AppBundle\Form\TenantType', $tenant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tenant);
            $em->flush();

            return $this->redirectToRoute('tenant_edit', array('id' => $tenant->getId()));
        }

        return $this->render('tenant/edit.html.twig', array(
            'tenant' => $tenant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tenant entity.
     *
     * @Route("/{id}", name="tenant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tenant $tenant)
    {
        $form = $this->createDeleteForm($tenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tenant);
            $em->flush();
        }

        return $this->redirectToRoute('tenant_index');
    }

    /**
     * Creates a form to delete a Tenant entity.
     *
     * @param Tenant $tenant The Tenant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tenant $tenant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tenant_delete', array('id' => $tenant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

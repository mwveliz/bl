<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackAltinv;
use BL\SGIBundle\Form\TrackAltinvType;

/**
 * TrackAltinv controller.
 *
 * @Route("/trackaltinv")
 */
class TrackAltinvController extends Controller
{
    /**
     * Lists all TrackAltinv entities.
     *
     * @Route("/", name="trackaltinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trackAltinvs = $em->getRepository('SGIBundle:TrackAltinv')->findAll();

        return $this->render('trackaltinv/index.html.twig', array(
            'trackAltinvs' => $trackAltinvs,
        ));
    }

    /**
     * Creates a new TrackAltinv entity.
     *
     * @Route("/new", name="trackaltinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trackAltinv = new TrackAltinv();
        $form = $this->createForm('BL\SGIBundle\Form\TrackAltinvType', $trackAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackAltinv);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackAltinv x WHERE x.id = ?1');
            $query->setParameter(1, $trackAltinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TrackAltinv', 
                            $trackAltinv->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('trackaltinv_show', array('id' => $trackaltinv->getId()));
        }

        return $this->render('trackaltinv/new.html.twig', array(
            'trackAltinv' => $trackAltinv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrackAltinv entity.
     *
     * @Route("/{id}", name="trackaltinv_show")
     * @Method("GET")
     */
    public function showAction(TrackAltinv $trackAltinv)
    {
        $deleteForm = $this->createDeleteForm($trackAltinv);

        return $this->render('trackaltinv/show.html.twig', array(
            'trackAltinv' => $trackAltinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrackAltinv entity.
     *
     * @Route("/{id}/edit", name="trackaltinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrackAltinv $trackAltinv)
    {
        $deleteForm = $this->createDeleteForm($trackAltinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\TrackAltinvType', $trackAltinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackAltinv);
            $em->flush();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackAltinv x WHERE x.id = ?1');
            $query->setParameter(1, $trackAltinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TrackAltinv', 
                            $trackAltinv->getId());
            */
            
            // fin proceso log            

            return $this->redirectToRoute('trackaltinv_edit', array('id' => $trackAltinv->getId()));
        }

        return $this->render('trackaltinv/edit.html.twig', array(
            'trackAltinv' => $trackAltinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrackAltinv entity.
     *
     * @Route("/{id}", name="trackaltinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrackAltinv $trackAltinv)
    {
        $form = $this->createDeleteForm($trackAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackAltinv x WHERE x.id = ?1');
            $query->setParameter(1, $trackAltinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TrackAltinv', 
                            $trackAltinv->getId());
            */
            
            // fin proceso log 
            
            $em->remove($trackAltinv);
            $em->flush();
        }

        return $this->redirectToRoute('trackaltinv_index');
    }

    /**
     * Creates a form to delete a TrackAltinv entity.
     *
     * @param TrackAltinv $trackAltinv The TrackAltinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrackAltinv $trackAltinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trackaltinv_delete', array('id' => $trackAltinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

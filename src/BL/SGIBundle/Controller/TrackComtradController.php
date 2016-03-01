<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackComtrad;
use BL\SGIBundle\Form\TrackComtradType;

/**
 * TrackComtrad controller.
 *
 * @Route("/trackcomtrad")
 */
class TrackComtradController extends Controller
{
    /**
     * Lists all TrackComtrad entities.
     *
     * @Route("/", name="trackcomtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trackComtrads = $em->getRepository('SGIBundle:TrackComtrad')->findAll();

        return $this->render('trackcomtrad/index.html.twig', array(
            'trackComtrads' => $trackComtrads,
        ));
    }

    /**
     * Creates a new TrackComtrad entity.
     *
     * @Route("/new", name="trackcomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trackComtrad = new TrackComtrad();
        $form = $this->createForm('BL\SGIBundle\Form\TrackComtradType', $trackComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackComtrad);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $trackComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TrackComtrad', 
                            $trackComtrad->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('trackcomtrad_show', array('id' => $trackcomtrad->getId()));
        }

        return $this->render('trackcomtrad/new.html.twig', array(
            'trackComtrad' => $trackComtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrackComtrad entity.
     *
     * @Route("/{id}", name="trackcomtrad_show")
     * @Method("GET")
     */
    public function showAction(TrackComtrad $trackComtrad)
    {
        $deleteForm = $this->createDeleteForm($trackComtrad);

        return $this->render('trackcomtrad/show.html.twig', array(
            'trackComtrad' => $trackComtrad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrackComtrad entity.
     *
     * @Route("/{id}/edit", name="trackcomtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrackComtrad $trackComtrad)
    {
        $deleteForm = $this->createDeleteForm($trackComtrad);
        $editForm = $this->createForm('BL\SGIBundle\Form\TrackComtradType', $trackComtrad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackComtrad);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $trackComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TrackComtrad', 
                            $trackComtrad->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('trackcomtrad_edit', array('id' => $trackComtrad->getId()));
        }

        return $this->render('trackcomtrad/edit.html.twig', array(
            'trackComtrad' => $trackComtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrackComtrad entity.
     *
     * @Route("/{id}", name="trackcomtrad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrackComtrad $trackComtrad)
    {
        $form = $this->createDeleteForm($trackComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $trackComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TrackComtrad', 
                            $trackComtrad->getId());
            */
            
            // fin proceso log   
            
            $em->remove($trackComtrad);
            $em->flush();
        }

        return $this->redirectToRoute('trackcomtrad_index');
    }

    /**
     * Creates a form to delete a TrackComtrad entity.
     *
     * @param TrackComtrad $trackComtrad The TrackComtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrackComtrad $trackComtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trackcomtrad_delete', array('id' => $trackComtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

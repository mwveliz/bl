<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\FieldsComtrad;
use BL\SGIBundle\Form\FieldsComtradType;
use Doctrine\ORM\Query;

/**
 * FieldsComtrad controller.
 *
 * @Route("/fieldscomtrad")
 */
class FieldsComtradController extends Controller
{
    /**
     * Lists all FieldsComtrad entities.
     *
     * @Route("/", name="fieldscomtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsComtrads = $em->getRepository('SGIBundle:FieldsComtrad')->findAll();

        return $this->render('fieldscomtrad/index.html.twig', array(
            'fieldsComtrads' => $fieldsComtrads,
        ));
    }

    /**
     * Creates a new FieldsComtrad entity.
     *
     * @Route("/new", name="fieldscomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fieldsComtrad = new FieldsComtrad();
        $form = $this->createForm('BL\SGIBundle\Form\FieldsComtradType', $fieldsComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsComtrad);
            $em->flush();

            $fieldsComtrads = $em->getRepository('SGIBundle:FieldsComtrad')->findAll();

            // Procedo log
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());

            $query = $em->createQuery('SELECT x FROM SGIBundle:FieldsComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $fieldsComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'FieldsComtrad', 
                            $fieldsComtrad->getId());

            // fin proceso log  
            
            return $this->render('fieldscomtrad/index.html.twig', array(
                'fieldsComtrads' => $fieldsComtrads,
            ));        
            
        }

        return $this->render('fieldscomtrad/new.html.twig', array(
            'fieldsComtrad' => $fieldsComtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FieldsComtrad entity.
     *
     * @Route("/{id}", name="fieldscomtrad_show")
     * @Method("GET")
     */
    public function showAction(FieldsComtrad $fieldsComtrad)
    {
        $deleteForm = $this->createDeleteForm($fieldsComtrad);

        return $this->render('fieldscomtrad/show.html.twig', array(
            'fieldsComtrad' => $fieldsComtrad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FieldsComtrad entity.
     *
     * @Route("/{id}/edit", name="fieldscomtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FieldsComtrad $fieldsComtrad)
    {
        $deleteForm = $this->createDeleteForm($fieldsComtrad);
        $editForm = $this->createForm('BL\SGIBundle\Form\FieldsComtradType', $fieldsComtrad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fieldsComtrad);
            $em->flush();
            
            // Procedo log
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());

            $query = $em->createQuery('SELECT x FROM SGIBundle:FieldsComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $fieldsComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'FieldsComtrad', 
                            $fieldsComtrad->getId());

            // fin proceso log            

            $fieldsComtrads = $em->getRepository('SGIBundle:FieldsComtrad')->findAll();

            return $this->render('fieldscomtrad/index.html.twig', array(
                'fieldsComtrads' => $fieldsComtrads,
            ));
        
        }

        return $this->render('fieldscomtrad/edit.html.twig', array(
            'fieldsComtrad' => $fieldsComtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FieldsComtrad entity.
     *
     * @Route("/delete/{id}", name="fieldscomtrad_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, FieldsComtrad $fieldsComtrad)
    {             
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());

            $query = $em->createQuery('SELECT x FROM SGIBundle:FieldsComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $fieldsComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'FieldsComtrad', 
                            $fieldsComtrad->getId());

            // fin proceso log  
            
            $em->remove($fieldsComtrad);
            $em->flush();

        return $this->redirectToRoute('fieldscomtrad_index');
    }

    /**
     * Creates a form to delete a FieldsComtrad entity.
     *
     * @param FieldsComtrad $fieldsComtrad The FieldsComtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FieldsComtrad $fieldsComtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fieldscomtrad_delete', array('id' => $fieldsComtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

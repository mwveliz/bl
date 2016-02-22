<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TypeComtrad;
use BL\SGIBundle\Form\TypeComtradType;

/**
 * TypeComtrad controller.
 *
 * @Route("/typecomtrad")
 */
class TypeComtradController extends Controller
{
    /**
     * Lists all TypeComtrad entities.
     *
     * @Route("/", name="typecomtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeComtrads = $em->getRepository('SGIBundle:TypeComtrad')->findAll();

        return $this->render('typecomtrad/index.html.twig', array(
            'typeComtrads' => $typeComtrads,
        ));
    }

    /**
     * Creates a new TypeComtrad entity.
     *
     * @Route("/new", name="typecomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeComtrad = new TypeComtrad();
        $form = $this->createForm('BL\SGIBundle\Form\TypeComtradType', $typeComtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeComtrad);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $typeComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TypeComtrad', 
                            $typeComtrad->getId());
            */
            
            // fin proceso log            
            
            $typeComtrads = $em->getRepository('SGIBundle:TypeComtrad')->findAll();

            return $this->render('typecomtrad/index.html.twig', array(
                'typeComtrads' => $typeComtrads,
            ));            
            
        }

        return $this->render('typecomtrad/new.html.twig', array(
            'typeComtrad' => $typeComtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeComtrad entity.
     *
     * @Route("/{id}", name="typecomtrad_show")
     * @Method("GET")
     */
    public function showAction(TypeComtrad $typeComtrad)
    {
        $deleteForm = $this->createDeleteForm($typeComtrad);

        return $this->render('typecomtrad/show.html.twig', array(
            'typeComtrad' => $typeComtrad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeComtrad entity.
     *
     * @Route("/{id}/edit", name="typecomtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeComtrad $typeComtrad)
    {
        $deleteForm = $this->createDeleteForm($typeComtrad);
        $editForm = $this->createForm('BL\SGIBundle\Form\TypeComtradType', $typeComtrad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeComtrad);
            $em->flush();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $typeComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TypeComtrad', 
                            $typeComtrad->getId());
            */
            
            // fin proceso log            
            
            $typeComtrads = $em->getRepository('SGIBundle:TypeComtrad')->findAll();

            return $this->render('typecomtrad/index.html.twig', array(
                'typeComtrads' => $typeComtrads,
            ));            

        }

        return $this->render('typecomtrad/edit.html.twig', array(
            'typeComtrad' => $typeComtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeComtrad entity.
     *
     * @Route("/delete/{id}", name="typecomtrad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeComtrad $typeComtrad)
    {
            $em = $this->getDoctrine()->getManager();
        
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeComtrad x WHERE x.id = ?1');
            $query->setParameter(1, $typeComtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TypeComtrad', 
                            $typeComtrad->getId());
             * 
             */
            // end log
                       
            $em->remove($typeComtrad);
            $em->flush();

        return $this->redirectToRoute('typecomtrad_index');
    }

    /**
     * Creates a form to delete a TypeComtrad entity.
     *
     * @param TypeComtrad $typeComtrad The TypeComtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeComtrad $typeComtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typecomtrad_delete', array('id' => $typeComtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

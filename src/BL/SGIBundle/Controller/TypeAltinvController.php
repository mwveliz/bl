<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TypeAltinv;
use BL\SGIBundle\Form\TypeAltinvType;

/**
 * TypeAltinv controller.
 *
 * @Route("/typealtinv")
 */
class TypeAltinvController extends Controller
{
    /**
     * Lists all TypeAltinv entities.
     *
     * @Route("/", name="typealtinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeAltinvs = $em->getRepository('SGIBundle:TypeAltinv')->findAll();

        return $this->render('typealtinv/index.html.twig', array(
            'typeAltinvs' => $typeAltinvs,
        ));
    }

    /**
     * Creates a new TypeAltinv entity.
     *
     * @Route("/new", name="typealtinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ruta='typealtinv/new.html.twig';
        $typeAltinv = new TypeAltinv();
        $form = $this->createForm('BL\SGIBundle\Form\TypeAltinvType', $typeAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeAltinv);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeAltinv x WHERE x.id = ?1');
            $query->setParameter(1, $typeAltinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TypeAltinv', 
                            $typeAltinv->getId());
            */
            
            // fin proceso log            
            
            return $this->redirectToRoute('typealtinv_index');
        }


        if ($request->isXmlHttpRequest()) $ruta='typealtinv/ajax_new.html.twig'; //si es por ajhax cargo el twig

        return $this->render($ruta, array(
            'typeAltinv' => $typeAltinv,
            'form' => $form->createView(),
        ));



    }


    /**
     * Create Altinv Type entities.
     *
     * @Route("/add", name="ajax_typealtinv_create")
     * @Method("POST")
     */
    public function ajaxCreateTypeAltinv(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new TypeAltinv();
        $object->setDescription( $request->get('description') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }




    /**
     * Finds and displays a TypeAltinv entity.
     *
     * @Route("/{id}", name="typealtinv_show")
     * @Method("GET")
     */
    public function showAction(TypeAltinv $typeAltinv)
    {
        $deleteForm = $this->createDeleteForm($typeAltinv);

        return $this->render('typealtinv/show.html.twig', array(
            'typeAltinv' => $typeAltinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeAltinv entity.
     *
     * @Route("/{id}/edit", name="typealtinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeAltinv $typeAltinv)
    {
        $deleteForm = $this->createDeleteForm($typeAltinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\TypeAltinvType', $typeAltinv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeAltinv);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeAltinv x WHERE x.id = ?1');
            $query->setParameter(1, $typeAltinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TypeAltinv', 
                            $typeAltinv->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('typealtinv_edit', array('id' => $typeAltinv->getId()));
        }

        return $this->render('typealtinv/edit.html.twig', array(
            'typeAltinv' => $typeAltinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeAltinv entity.
     *
     * @Route("/{id}", name="typealtinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeAltinv $typeAltinv)
    {
        $form = $this->createDeleteForm($typeAltinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeAltinv x WHERE x.id = ?1');
            $query->setParameter(1, $typeAltinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TypeAltinv', 
                            $typeAltinv->getId());
            */
            
            // fin proceso log
            
            $em->remove($typeAltinv);
            $em->flush();
        }

        return $this->redirectToRoute('typealtinv_index');
    }

    /**
     * Creates a form to delete a TypeAltinv entity.
     *
     * @param TypeAltinv $typeAltinv The TypeAltinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeAltinv $typeAltinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typealtinv_delete', array('id' => $typeAltinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

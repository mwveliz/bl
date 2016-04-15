<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * Create Comtrad Fields entities via ajax.
     *
     * @Route("/add", name="ajax_fieldscomtrad_create")
     * @Method("POST")
     */
    public function ajaxCreateFieldsComtrad(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new FieldsComtrad();
        $object->setDescription( $request->get('description') );
        $object->setWiget($request->get('widget') );
        $object->setTrackable(false);
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }
    
    
    /**
     * Remove Comtrad Fields entities from form via ajax.
     *
     * @Route("/remo", name="ajax_fieldscomtrad_remove")
     * @Method("POST")
     */
    public function ajaxRemoveFieldsComtrad(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new FieldsComtrad();
        $object->setDescription( $request->get('description') );
        $object->setWiget($request->get('widget') );
        $object->setTrackable($request->get('trackable') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }

    /**
     * Creates a new FieldsComtrad entity.
     *
     * @Route("/new", name="fieldscomtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ruta='fieldscomtrad/new.html.twig';
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
            
            if ($request->isXmlHttpRequest()) $ruta='fieldscomtrad/ajax_new.html.twig'; //si es por ajhax cargo el twig
            
            return $this->render($ruta, array(
                'fieldsComtrads' => $fieldsComtrads,
            ));        
            
        }
        if ($request->isXmlHttpRequest()) $ruta='fieldscomtrad/ajax_new.html.twig'; //si es por ajhax cargo el twig

        return $this->render($ruta, array(
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
        $id = $fieldsComtrad->getId();  
        $form = 'FieldsComtrad';  
        $table = 'SGIBundle:'.$form;
                
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($table)->findOneBy(array('id' => $id));
                       
        $form_lowcase = strtolower($form);
        
        $ruta = $form_lowcase.'/show.html.twig';
        
        return $this->render($ruta, array(
            'object' => $object,
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

<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackComtrad;
use BL\SGIBundle\Form\TrackComtradType;
use BL\SGIBundle\Entity\FieldsComtrad;
use BL\SGIBundle\Entity\BlComtrad;

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
     * Create Comtrad Track Fields entities via ajax.
     *
     * @Route("/fieldtrackadd", name="ajax_fieldstrackcomtrad_create")
     * @Method("POST")
     */
    public function ajaxCreateFieldsTrackComtrad(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //primero creo elcampo en fields comtrad trackable true
        $object= new FieldsComtrad();
        $object->setDescription( $request->get('description') );
        $object->setWiget('Currency' );
        $object->setTrackable(true);
        $em->persist($object);
        $em->flush();
        $id_field=$em->getReference('BL\SGIBundle\Entity\FieldsComtrad', intval($object->getId()));     
        
        $id_comtrad = $em->getReference('BL\SGIBundle\Entity\Comtrad', $request->get('id_comtrad'));     
     
        $object= new BlComtrad();
        $object->setIdField($id_field);
        $object->setIdComtrad( $id_comtrad);
        $em->persist($object);
        $em->flush();
          return new JsonResponse($id_field);
    }

    
    
     /**
     * Tracks one  Alternative Investment Account.
     *
     * @Route("track/{id}", name="trackcomtrad_track")
     * @Method("GET")
     */
    public function trackAction(Request $request)
    {
        $idcomtrad=$request->get('id');
          $fieldsComtrad = new FieldsComtrad();
     $form = $this->createForm('BL\SGIBundle\Form\FieldsComtradType', $fieldsComtrad);
     $em = $this->getDoctrine()->getManager();
        $fields=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:FieldsComtrad f')
             
             ->Join('SGIBundle:BlComtrad', 'b')
             ->where('b.idField = f.id ')
            ->andWhere('f.trackable=true')
             ->andWhere('b.idComtrad=:id')
             ->setParameter('id', $idcomtrad)
             ->getQuery()
             ->getResult();
    
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($fields, 'json');
       
      
        return $this->render('trackcomtrad/track.html.twig', array(
            'objects' => $objects,
            'form' =>$form->createView(),
        ));
    }
    
     /**
     * Create TrackComtrad entities via ajax.
     *
     * @Route("/add", name="ajax_trackcomtrad_create")
     * @Method("POST")
     */
    public function ajaxCreateTrackComtrad(Request $request)
    {
        
         $mes=$request->get('mes');
        if($mes<10) $mes="0".$mes;
        //$fecha= 'd-'.$mes.'-y h:i:s';
        $fecha =  new \DateTime();
        $fecha->setDate(date('Y'),$mes, 01);
        $fecha->setTime(0,0, 0);
        
        $value=$request->get('valor');
        $em = $this->getDoctrine()->getManager();
        $id_fieldscomtrad = $em->getReference('BL\SGIBundle\Entity\FieldsComtrad', $request->get('id_fieldscomtrad'));      
        $id_comtrad = $em->getReference('BL\SGIBundle\Entity\Comtrad', $request->get('id_comtrad'));     
        
        /*antes que nada buscar si ya esta el registro, si esya modificar*/
        $object= $em->getRepository('SGIBundle:TrackComtrad')
          ->findOneBy(array(
            'idComtrad'=> $id_comtrad, 
            'idFieldsTrackComtrad' => $id_fieldscomtrad,
            'datetime'=> $fecha,
         
           ));
        
      
        
        if(count($object)==0) $object= new TrackComtrad();
       
                
     
           
        $object->setIdComtrad($id_comtrad ); //objeto de tipo comtrad
        $object->setIdFieldsTrackComtrad($id_fieldscomtrad); //objeto de tipo fields comtrad
        $object->setDatetime($fecha);
        $object->setValue($value);
        
        
        $em->persist($object);
        $em->flush();
        
        
        return new Response($object->getId());
        
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

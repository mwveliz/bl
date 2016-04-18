<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackAltinv;
use BL\SGIBundle\Form\TrackAltinvType;
use BL\SGIBundle\Entity\FieldsAltinv;
use BL\SGIBundle\Entity\FieldsTrackAltinv;
use BL\SGIBundle\Entity\BlAltinv;

use BL\SGIBundle\Form\FieldsAltinvType;
use Symfony\Component\Validator\Constraints\DateTime;
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
     * Create Altinv Track Fields entities via ajax.
     *
     * @Route("/fieldtrackadd", name="ajax_fieldstrackaltinv_create")
     * @Method("POST")
     */
    public function ajaxCreateFieldsTrackAltinv(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //primero creo elcampo en fields altinv trackable true
        $object= new FieldsAltinv();
        $object->setDescription( $request->get('description') );
        $object->setWidget( $request->get('credordeb').','.$request->get('currency_symbol') ); //utilizo el symbol y su signo en el  widget
        $object->setTrackable(true);
        $em->persist($object);
        $em->flush();
        $id_field=$em->getReference('BL\SGIBundle\Entity\FieldsAltinv', intval($object->getId()));     
        
        $id_altinv = $em->getReference('BL\SGIBundle\Entity\Altinv', $request->get('id_altinv'));     
     
        $object= new BlAltinv();
        $object->setIdField($id_field);
        $object->setIdAltinv( $id_altinv);
        $em->persist($object);
        $em->flush();
        

        return new JsonResponse($id_field);
    }

    
    
     /**
     * Tracks one  Alternative Investment Account.
     *
     * @Route("track/{id}", name="trackaltinv_track")
     * @Method("GET")
     */
    public function trackAction(Request $request)
    {
     $i=0; 
     $idaltinv=$request->get('id');
     $fieldsAltinv = new FieldsAltinv();
     $form = $this->createForm('BL\SGIBundle\Form\FieldsAltinvType', $fieldsAltinv);
     $em = $this->getDoctrine()->getManager();
        $fields=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:FieldsAltinv f')
             ->Join('SGIBundle:BlAltinv', 'b')
             ->where('b.idField = f.id ')
            ->andWhere('f.trackable=true')
             ->andWhere('b.idAltinv=:id')
             ->setParameter('id', $idaltinv)
             ->add('orderBy','f.id ASC')
             ->getQuery()
             ->getResult();
        
        
        
        $filas=$em->getRepository('SGIBundle:BlAltinv')
                ->findBy(
                    array('idAltinv'=> $idaltinv),
                    array('idField' => 'ASC')
            );
        
        
        ;
        foreach($filas as $fila){//itero sobre cada campo financial trackable para tomnar sus vaores por mes
            
            $columnas=$em->getRepository('SGIBundle:TrackAltinv')
                ->findBy(
                    array('idFieldsTrackAltinv'=> $fila->getIdField()),
                    array('idFieldsTrackAltinv' => 'ASC')
            );
           
            if(count($columnas)>0){
                $i++;//incremento la fila para la matriz si exsite para este id
           
                foreach($columnas as $col){
                    $dateObj=$col->getDatetime(); 
                    list($dia,$mes,$anio)=explode('-', $dateObj->format('Y-m-d H:i:s') );
                    $mes=chr(trim($mes, "0")+64);
                    $matriz[$mes.$i]=$col->getValue();
                }
            }//fin si el count de columnas>0
            
        }
        
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($fields, 'json');
        $cifras= $serializer->serialize($matriz, 'json');
       
      
        return $this->render('trackaltinv/track.html.twig', array(
            'objects' => $objects,
            'cifras' => $cifras,
            
            'form' =>$form->createView(),
        ));
    }
    
     /**
     * Create TrackAltinv entities via ajax.
     *
     * @Route("/add", name="ajax_trackaltinv_create")
     * @Method("POST")
     */
    public function ajaxCreateTrackAltinv(Request $request)
    {
        
         $mes=$request->get('mes');
         $id_fields_track_altinv= intval($request->get('id_fieldsaltinv'));
         
        if($mes<10) $mes="0".$mes;
        //$fecha= 'd-'.$mes.'-y h:i:s';
        $date=date('Y').'-'.$mes.'-01';
        $time='00:00:00';
        $datetime=$date.' '.$time;
        $fecha =  new \DateTime();
        $fecha->setDate(date('Y'),$mes, 01);
        $fecha->setTime(0,0,0);
        
        //$fecha_obj=new TrackAltinv();
        //$fecha_obj->setDatetime($datetime);
        
        //$fecha = $fecha_obj->getDatetime();
        //$fecha=date('Y').'-01-01 00:00:00';
        
        $value=$request->get('valor');
        $em = $this->getDoctrine()->getManager();
        $id_fieldsaltinv = $em->getReference('BL\SGIBundle\Entity\FieldsAltinv', $request->get('id_fieldsaltinv'));      
        $id_altinv = $em->getReference('BL\SGIBundle\Entity\Altinv', $request->get('id_altinv'));     
        
        
        /*antes que nada buscar si ya esta el registro, si esta modificar*/
        $object=$em->getRepository('SGIBundle:TrackAltinv')
              ->findOneBy(array(
                    'idAltinv'=> $id_altinv, 
                    'idFieldsTrackAltinv' => $id_fields_track_altinv,
                    'datetime'=> $fecha,
           ));
        
        if(count($object)==0) $object= new TrackAltinv();
        $object->setIdAltinv($id_altinv ); //objeto de tipo altinv
        $object->setIdFieldsTrackAltinv($id_fieldsaltinv); //objeto de tipo fields altinv
        $object->setDatetime($fecha);
        $object->setValue($value);
       
        $em->persist($object);
        $em->flush();
        
        return new Response($object->getId());
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

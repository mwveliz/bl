<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackRental;
use BL\SGIBundle\Form\TrackRentalType;
use BL\SGIBundle\Entity\FieldsRental;
use BL\SGIBundle\Entity\BlRental;

/**
 * TrackRental controller.
 *
 * @Route("/trackrental")
 */
class TrackRentalController extends Controller
{
    /**
     * Lists all TrackRental entities.
     *
     * @Route("/", name="trackrental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trackRentals = $em->getRepository('SGIBundle:TrackRental')->findAll();

        return $this->render('trackrental/index.html.twig', array(
            'trackRentals' => $trackRentals,
        ));
    }

    /**
     * Create Rental Track Fields entities via ajax.
     *
     * @Route("/fieldtrackadd", name="ajax_fieldstrackrental_create")
     * @Method("POST")
     */
    public function ajaxCreateFieldsTrackRental(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //primero creo elcampo en fields rental trackable true
        $object= new FieldsRental();
        $object->setDescription( $request->get('description') );
        $object->setWidget('Currency' );
        $object->setTrackable(true);
        $em->persist($object);
        $em->flush();
        $id_field=$em->getReference('BL\SGIBundle\Entity\FieldsRental', intval($object->getId()));     
        
        $id_rental = $em->getReference('BL\SGIBundle\Entity\Rental', $request->get('id_rental'));     
     
        $object= new BlRental();
        $object->setIdField($id_field);
        $object->setIdRental( $id_rental);
        $em->persist($object);
        $em->flush();
        

        return new JsonResponse($id_field);
    }

    
    
     /**
     * Tracks one  Alternative Investment Account.
     *
     * @Route("track/{id}", name="trackrental_track")
     * @Method("GET")
     */
    public function trackAction(Request $request)
    {
        $idrental=$request->get('id');
          $fieldsRental = new FieldsRental();
     $form = $this->createForm('BL\SGIBundle\Form\FieldsRentalType', $fieldsRental);
     $em = $this->getDoctrine()->getManager();
        $fields=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:FieldsRental f')
             
             ->Join('SGIBundle:BlRental', 'b')
             ->where('b.idField = f.id ')
            ->andWhere('f.trackable=true')
             ->andWhere('b.idRental=:id')
             ->setParameter('id', $idrental)
             ->getQuery()
             ->getResult();
    
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($fields, 'json');
       
      
        return $this->render('trackrental/track.html.twig', array(
            'objects' => $objects,
            'form' =>$form->createView(),
        ));
    }
    
     /**
     * Create TrackRental entities via ajax.
     *
     * @Route("/add", name="ajax_trackrental_create")
     * @Method("POST")
     */
    public function ajaxCreateTrackRental(Request $request)
    {
        
         $mes=$request->get('mes');
        if($mes<10) $mes="0".$mes;
        //$fecha= 'd-'.$mes.'-y h:i:s';
        $fecha =  new \DateTime();
        $fecha->setDate(date('Y'),$mes, 01);
        $fecha->setTime(0,0, 0);
        
        $value=$request->get('valor');
        $em = $this->getDoctrine()->getManager();
        $id_fieldsrental = $em->getReference('BL\SGIBundle\Entity\FieldsRental', $request->get('id_fieldsrental'));      
        $id_rental = $em->getReference('BL\SGIBundle\Entity\Rental', $request->get('id_rental'));     
        
        /*antes que nada buscar si ya esta el registro, si esya modificar*/
        $object= $em->getRepository('SGIBundle:TrackRental')
          ->findOneBy(array(
            'idRental'=> $id_rental, 
            'idFieldsTrackRental' => $id_fieldsrental,
            'datetime'=> $fecha,
         
           ));
        
      
        
        if(count($object)==0) $object= new TrackRental();
       
                
     
           
        $object->setIdRental($id_rental ); //objeto de tipo rental
        $object->setIdFieldsTrackRental($id_fieldsrental); //objeto de tipo fields rental
        $object->setDatetime($fecha);
        $object->setValue($value);
        
        
        $em->persist($object);
        $em->flush();
        
        
        return new Response($object->getId());
        
    }
    
    /**
     * Creates a new TrackRental entity.
     *
     * @Route("/new", name="trackrental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trackRental = new TrackRental();
        $form = $this->createForm('BL\SGIBundle\Form\TrackRentalType', $trackRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackRental);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackRental x WHERE x.id = ?1');
            $query->setParameter(1, $trackRental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TrackRental', 
                            $trackRental->getId());
            */
            
            // fin proceso log              
            
            return $this->redirectToRoute('trackrental_show', array('id' => $trackrental->getId()));
        }

        return $this->render('trackrental/new.html.twig', array(
            'trackRental' => $trackRental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrackRental entity.
     *
     * @Route("/{id}", name="trackrental_show")
     * @Method("GET")
     */
    public function showAction(TrackRental $trackRental)
    {
        $deleteForm = $this->createDeleteForm($trackRental);

        return $this->render('trackrental/show.html.twig', array(
            'trackRental' => $trackRental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrackRental entity.
     *
     * @Route("/{id}/edit", name="trackrental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrackRental $trackRental)
    {
        $deleteForm = $this->createDeleteForm($trackRental);
        $editForm = $this->createForm('BL\SGIBundle\Form\TrackRentalType', $trackRental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackRental);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackRental x WHERE x.id = ?1');
            $query->setParameter(1, $trackRental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TrackRental', 
                            $trackRental->getId());
            */
            
            // fin proceso log            
            
            return $this->redirectToRoute('trackrental_edit', array('id' => $trackRental->getId()));
        }

        return $this->render('trackrental/edit.html.twig', array(
            'trackRental' => $trackRental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrackRental entity.
     *
     * @Route("/{id}", name="trackrental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrackRental $trackRental)
    {
        $form = $this->createDeleteForm($trackRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackRental x WHERE x.id = ?1');
            $query->setParameter(1, $trackRental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TrackRental', 
                            $trackRental->getId());
            */
            
            // fin proceso log
            
            
            $em->remove($trackRental);
            $em->flush();
        }

        return $this->redirectToRoute('trackrental_index');
    }

    /**
     * Creates a form to delete a TrackRental entity.
     *
     * @param TrackRental $trackRental The TrackRental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrackRental $trackRental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trackrental_delete', array('id' => $trackRental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

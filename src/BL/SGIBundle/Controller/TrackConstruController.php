<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TrackConstru;
use BL\SGIBundle\Form\TrackConstruType;
use BL\SGIBundle\Entity\FieldsConstru;
use BL\SGIBundle\Entity\BlConstru;

/**
 * TrackConstru controller.
 *
 * @Route("/trackconstru")
 */
class TrackConstruController extends Controller
{
    /**
     * Lists all TrackConstru entities.
     *
     * @Route("/", name="trackconstru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trackConstrus = $em->getRepository('SGIBundle:TrackConstru')->findAll();

        return $this->render('trackconstru/index.html.twig', array(
            'trackConstrus' => $trackConstrus,
        ));
    }

    /**
     * Create Constru Track Fields entities via ajax.
     *
     * @Route("/fieldtrackadd", name="ajax_fieldstrackconstru_create")
     * @Method("POST")
     */
    public function ajaxCreateFieldsTrackConstru(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //primero creo elcampo en fields constru trackable true
        $object= new FieldsConstru();
        $object->setDescription( $request->get('description') );
        $object->setWidget('Currency' );
        $object->setTrackable(true);
        $em->persist($object);
        $em->flush();
        $id_field=$em->getReference('BL\SGIBundle\Entity\FieldsConstru', intval($object->getId()));     
        
        $id_constru = $em->getReference('BL\SGIBundle\Entity\Constru', $request->get('id_constru'));     
     
        $object= new BlConstru();
        $object->setIdField($id_field);
        $object->setIdConstru( $id_constru);
        $em->persist($object);
        $em->flush();
        

        return new JsonResponse($id_field);
    }

    
    
     /**
     * Tracks one  COnstruction Account.
     *
     * @Route("track/{id}", name="trackconstru_track")
     * @Method("GET")
     */
    public function trackAction(Request $request)
    {
        $idconstru=$request->get('id');
          $fieldsConstru = new FieldsConstru();
     $form = $this->createForm('BL\SGIBundle\Form\FieldsConstruType', $fieldsConstru);
     $em = $this->getDoctrine()->getManager();
        $fields=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:FieldsConstru f')
             
             ->Join('SGIBundle:BlConstru', 'b')
             ->where('b.idField = f.id ')
            ->andWhere('f.trackable=true')
             ->andWhere('b.idConstru=:id')
             ->setParameter('id', $idconstru)
             ->getQuery()
             ->getResult();
    
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($fields, 'json');
       
      
        return $this->render('trackconstru/track.html.twig', array(
            'objects' => $objects,
            'form' =>$form->createView(),
        ));
    }
    
     /**
     * Create TrackConstru entities via ajax.
     *
     * @Route("/add", name="ajax_trackconstru_create")
     * @Method("POST")
     */
    public function ajaxCreateTrackConstru(Request $request)
    {
        
         $mes=$request->get('mes');
        if($mes<10) $mes="0".$mes;
        //$fecha= 'd-'.$mes.'-y h:i:s';
        $fecha =  new \DateTime();
        $fecha->setDate(date('Y'),$mes, 01);
        $fecha->setTime(0,0, 0);
        
        $value=$request->get('valor');
        $em = $this->getDoctrine()->getManager();
        $id_fieldsconstru = $em->getReference('BL\SGIBundle\Entity\FieldsConstru', $request->get('id_fieldsconstru'));      
        $id_constru = $em->getReference('BL\SGIBundle\Entity\Constru', $request->get('id_constru'));     
        
        /*antes que nada buscar si ya esta el registro, si esya modificar*/
        $object= $em->getRepository('SGIBundle:TrackConstru')
          ->findOneBy(array(
            'idConstru'=> $id_constru, 
            'idFieldsTrackConstru' => $id_fieldsconstru,
            'datetime'=> $fecha,
         
           ));
        
      
        
        if(count($object)==0) $object= new TrackConstru();
       
                
     
           
        $object->setIdConstru($id_constru ); //objeto de tipo constru
        $object->setIdFieldsTrackConstru($id_fieldsconstru); //objeto de tipo fields constru
        $object->setDatetime($fecha);
        $object->setValue($value);
        
        
        $em->persist($object);
        $em->flush();
        
        
        return new Response($object->getId());
        
    }
    /**
     * Creates a new TrackConstru entity.
     *
     * @Route("/new", name="trackconstru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trackConstru = new TrackConstru();
        $form = $this->createForm('BL\SGIBundle\Form\TrackConstruType', $trackConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackConstru);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackConstru x WHERE x.id = ?1');
            $query->setParameter(1, $trackConstru->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TrackConstru', 
                            $trackConstru->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('trackconstru_show', array('id' => $trackconstru->getId()));
        }

        return $this->render('trackconstru/new.html.twig', array(
            'trackConstru' => $trackConstru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrackConstru entity.
     *
     * @Route("/{id}", name="trackconstru_show")
     * @Method("GET")
     */
    public function showAction(TrackConstru $trackConstru)
    {
        $deleteForm = $this->createDeleteForm($trackConstru);

        return $this->render('trackconstru/show.html.twig', array(
            'trackConstru' => $trackConstru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrackConstru entity.
     *
     * @Route("/{id}/edit", name="trackconstru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TrackConstru $trackConstru)
    {
        $deleteForm = $this->createDeleteForm($trackConstru);
        $editForm = $this->createForm('BL\SGIBundle\Form\TrackConstruType', $trackConstru);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trackConstru);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackConstru x WHERE x.id = ?1');
            $query->setParameter(1, $trackConstru->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TrackConstru', 
                            $trackConstru->getId());
            */
            
            // fin proceso log              
            
            return $this->redirectToRoute('trackconstru_edit', array('id' => $trackConstru->getId()));
        }

        return $this->render('trackconstru/edit.html.twig', array(
            'trackConstru' => $trackConstru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrackConstru entity.
     *
     * @Route("/{id}", name="trackconstru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TrackConstru $trackConstru)
    {
        $form = $this->createDeleteForm($trackConstru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TrackConstru x WHERE x.id = ?1');
            $query->setParameter(1, $trackConstru->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TrackConstru', 
                            $trackConstru->getId());
            */
            
            // fin proceso log  
            
            $em->remove($trackConstru);
            $em->flush();
        }

        return $this->redirectToRoute('trackconstru_index');
    }

    /**
     * Creates a form to delete a TrackConstru entity.
     *
     * @param TrackConstru $trackConstru The TrackConstru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrackConstru $trackConstru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trackconstru_delete', array('id' => $trackConstru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

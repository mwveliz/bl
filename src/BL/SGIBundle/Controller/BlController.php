<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Bl;
use BL\SGIBundle\Form\BlType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use BL\SGIBundle\Entity\TypeAltinv;
use BL\SGIBundle\Entity\TypeComtrad;
use BL\SGIBundle\Entity\TypeConstru;
use BL\SGIBundle\Entity\TypeRental;


/**
 * Bl controller.
 *
 * @Route("/bl")
 */
class BlController extends Controller
{
    /**
     * Lists all Bl entities.
     *
     * @Route("/", name="bl_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bls = $em->getRepository('SGIBundle:Bl')
                ->findBy(
                    array(), 
                    array('id' => 'DESC')
                );
        $objects = $em->getRepository('SGIBundle:TypeAltinv')
                ->findBy(
                    array(), 
                    array('id' => 'DESC')
                );
        return $this->render('bl/index.html.twig', array(
            'bls' => $bls,'objects' => $objects,
        ));
    }
    
    /**
     * Lists all Bl entities.
     *
     * @Route("/", name="bl_index_ajax")
     * @Method("POST")
     */
    public function ajaxindexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bls = $em->getRepository('SGIBundle:Bl')->findAll();
        $objeto=array();
        $arreglo=array();

        foreach($bls  as $bl){
            $indice=(string) $bl->getId();
            $objeto['id']=(string) $bl->getId();
            $objeto['value']= $bl->getDescription();
            array_push($arreglo, $objeto);
        }

        return new JsonResponse($arreglo);
    }
     /**
     * Finds and displays a TypeAltinv entity.
     *
     * @Route("/{id}", name="bl_accounts_per_opportunity")
     * @Method("GET")
     */
    public function blaccountsPerOpportunityAction(TypeAltinv $typeAltinv)
    {
        $em = $this->getDoctrine()->getManager();
        $objects = $em->getRepository('SGIBundle:Altinv')->findByIdTypeAltinv($typeAltinv);
        
        return $this->render('bl/accounts_per_opportunity.html.twig', array(
            'objects' => $objects,
            
        ));
    }
     /**
     * Tracks one   Account.
     *
     * @Route("track/{id}", name="bl_track")
     * @Method("GET")
     */
    public function trackAction(Request $request)
    {
       /* $id_bl=$request->get('id');
          $fieldsAltinv = new FieldsAltinv();
     $form = $this->createForm('BL\SGIBundle\Form\BlType', $fieldsAltinv);
     $em = $this->getDoctrine()->getManager();
        $fields=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:FieldsAltinv f')
             
             ->Join('SGIBundle:BlAltinv', 'b')
             ->where('b.idField = f.id ')
            ->andWhere('f.trackable=true')
             ->andWhere('b.idAltinv=:id')
             ->setParameter('id', $idaltinv)
             ->getQuery()
             ->getResult();
    
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($fields, 'json');
       */
      
        return $this->render('bl/track.html.twig', array(
           // 'objects' => $objects,
           // 'form' =>$form->createView(),
        ));
    }
    /**
     * Lists all Bl entities.
     *
     * @Route("/showala", name="ajax_showlogactivity")
     * @Method("POST")
     */
    public function showalaAction(Request $request)
    {      
        $id = $request->get('id');  
        $form = $request->get('form');  
        $table = 'SGIBundle:'.$form;
                
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($table)->findOneBy(array('id' => $id));
                       
        $form_lowcase = strtolower($form);
        
        $ruta = $form_lowcase.'/ajax_show.html.twig';
        
        switch ($form) {
            case 'Comtrad':
                $nombre_apellido = $object->getIdClient()->getNombre().' ';
                $nombre_apellido .= $object->getIdClient()->getApellido();
                
                $arreglo =  array('Id' => $object->getId(),
                    'Description' => $object->getDescription(),
                    'Country' => $object->getIdState()->getIdCountry()->getDescription(),
                    'State' => $object->getIdState()->getDescription(),
                    'Client' => $nombre_apellido,
                    );
                
                // List of Fields 
                $Fields = $em->getRepository('SGIBundle:BlComtrad')
                ->findBy(array('idComtrad' => $id));
                
                if (count($Fields) > 0) {
                    foreach ($Fields as $Field) {
                        $arreglo[$Field->getIdField()->getDescription()] = $Field->getValue();
                    }    
                }
                
                $object = $arreglo;
            default:
                break;
        }


        return $this->render($ruta, array(
            'object' => $object,
        ));
    }     

    /**
     * Creates a new Bl entity.
     *
     * @Route("/new", name="bl_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bl = new Bl();
        $form = $this->createForm('BL\SGIBundle\Form\BlType', $bl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();

            return $this->redirectToRoute('bl_show', array('id' => $bl->getId()));
        }

        return $this->render('bl/new.html.twig', array(
            'bl' => $bl,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bl entity.
     *
     * @Route("/{id}", name="bl_show")
     * @Method("GET")
     */
    public function showAction(Bl $bl)
    {
        $deleteForm = $this->createDeleteForm($bl);

        return $this->render('bl/show.html.twig', array(
            'bl' => $bl,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Bl entity.
     *
     * @Route("/{id}/edit", name="bl_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bl $bl)
    {
        $deleteForm = $this->createDeleteForm($bl);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlType', $bl);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();

            return $this->redirectToRoute('bl_edit', array('id' => $bl->getId()));
        }

        return $this->render('bl/edit.html.twig', array(
            'bl' => $bl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bl entity.
     *
     * @Route("/{id}", name="bl_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bl $bl)
    {
        $form = $this->createDeleteForm($bl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bl);
            $em->flush();
        }

        return $this->redirectToRoute('bl_index');
    }

    /**
     * Creates a form to delete a Bl entity.
     *
     * @param Bl $bl The Bl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bl $bl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bl_delete', array('id' => $bl->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
       
    
    /**
     * @Route("/ajax/mostrar", name="show_ajax")
     * @Method("GET")
     */   
    public function showajaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form_name = $request->get('form_name');
        $id = $request->get('id');  
        
        $arreglo = $this->showEntidad($form_name, $id);
                
        $form_name_lowcase = strtolower($form_name);
        $edit = $this->generateUrl($form_name_lowcase.'_edit', array('id' => $id));
        $delete = $this->generateUrl($form_name_lowcase.'_delete', array('id' => $id));   
               
        $objeto = '<div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-green">
                                        <i class="icon-settings font-green"></i>
                                        <span class="caption-subject bold uppercase">Show</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group" id="myDropdown">
                                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="'.$edit.'">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a data-href="'.$delete.'" data-toggle="confirmation" data-original-title="" title="" ><i class="fa fa-trash-o"></i> Delete </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>                                    
                                </div>   
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">';
        
        foreach ($arreglo as $key => $val) {
            if (strpos($val, 'photos/') !== false) {
                list($photos,$controller,$archivo) = explode("/", $val);
                $link = $this->generateUrl('download_image', array('filename' => $archivo,'controller' => $controller));
                $download = '&nbsp;&nbsp;&nbsp;<a href = "' . $link . '" class = "btn btn-info btn-sm">Download</a>';
                $val = '<a class="colorbox cboxElement"  href="/bl/web/'.$val.'"><img src="/bl/web/'.$val.'" height="100" width="100" /></a>'.$download;
            }
            $objeto .= '<tr><td width="40%"><strong>'.$key.': </strong></td><td>'.$val.'</td></tr>';
        }
                                        
        $objeto .= '</tbody></table></div></div>';
        
        return new JsonResponse($objeto);
    }

    /**
     * @param $form_name
     * @param $id
     * @return array
     */
    public function showEntidad($form_name, $id){
        $em = $this->getDoctrine()->getManager();

        $modelo = 'SGIBundle:'.$form_name;
        
        $form = $em->getRepository($modelo)
                ->findOneBy(array('id' => $id));
        
        $arreglo = array();
        
        switch ($form_name) {
            case 'Altinv':
                $nombre_apellido = $form->getIdClient()->getName().' ';
                $nombre_apellido .= $form->getIdClient()->getLastName();

                $arreglo =  array('Id' => $id,
                    'Description' => $form->getDescription(),
                    'Country' => $form->getIdState()->getIdCountry()->getDescription(),
                    'State' => $form->getIdState()->getDescription(),
                    'Client' => $nombre_apellido,
                );
            break;
            case 'FieldsComtrad':
                $trackable = $form->getTrackable() ? "True":"False";
                $arreglo =  array('Id' => $id,'Description' => $form->getDescription(),
                    'Widget' => $form->getWiget(), 'Trackable' => $trackable);
                break;  
            case 'Comtrad':
                $nombre_apellido = $form->getIdClient()->getNombre().' ';
                $nombre_apellido .= $form->getIdClient()->getApellido();
                
                $arreglo =  array('Id' => $id,
                    'Description' => $form->getDescription(),
                    'Country' => $form->getIdState()->getIdCountry()->getDescription(),
                    'State' => $form->getIdState()->getDescription(),
                    'Client' => $nombre_apellido,
                    );
                
                // List of Fields 
                $Fields = $em->getRepository('SGIBundle:BlComtrad')
                ->findBy(array('idComtrad' => $id));
                
                if (count($Fields) > 0) {
                    foreach ($Fields as $Field) {
                        $arreglo[$Field->getIdField()->getDescription()] = $Field->getValue();
                    }    
                }
                break;                   
            case 'Todo':
                $completed = $form->getCompleted() ? "True":"False";
                $nombre_apellido = $form->getUserid()->getNombre().' ';
                $nombre_apellido .= $form->getUserid()->getApellido();
                $arreglo =  array('Id' => $id,
                                  'Assigned To' => $nombre_apellido,
                                  'Business Line' => $form->getIdBl(),
                                  'Description' => $form->getDescription(),
                                  'Date' => $form->getDuedate()->format('d-m-Y'),
                                  'Priority' =>  $form->getIdPriority()->getDescription(),
                                  'Completed' =>  $completed  
                                  );
                break; 
            case 'TypeComtrad':
                $arreglo =  array('Id' => $id,'Description' => $form->getDescription());
                break;             
        }
        
        
        return $arreglo; 
    } 
    
    
    /**
     *
     * @Route("/download/{filename}/controller/{controller}", name="download_image")
     * @Method("GET")
     */    
    public function downloadAction($filename,$controller)
    {
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/photos/".$controller.'/';
        $content = file_get_contents($path.$filename);

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);
        return $response;
    } 
    
    /**
     * @Route("/ajax/cliente_estado", name="client_state_ajax")
     * @Method("GET")
     */   
    public function clientstateajaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $idclient = $request->get('idclient');
        $idstate = $request->get('idstate');
                
        $Client = $em->getRepository('SGIBundle:Client')
                ->findOneBy(array('id' => $idclient));  
        
        $State = $em->getRepository('SGIBundle:State')
                ->findOneBy(array('id' => $idstate));  
        
        $client = $Client->getUserid()->getNombre().' '.$Client->getUserid()->getApellido();
        $state = $State->getIdCountry()->getDescription().' - '.$State->getDescription();
        
        $arreglo = array();
        $arreglo['client'] = $client;
        $arreglo['state'] = $state;
        
        return new JsonResponse($arreglo);
    }
    
    
}

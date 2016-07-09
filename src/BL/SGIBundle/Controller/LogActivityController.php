<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\LogActivity;
use BL\SGIBundle\Form\LogActivityType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * LogActivity controller.
 *
 * @Route("/logactivity")
 */
class LogActivityController extends Controller
{
    /**
     * Lists all LogActivity entities.
     *
     * @Route("/", name="logactivity_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $logActivities = $em->getRepository('SGIBundle:LogActivity')
                ->findBy(array(),array('loggedAt' => 'DESC'));
                
        foreach ($logActivities as $logActivity) {
            $class = $logActivity->getObjectClass();
            $action = $logActivity->getAction();
            switch ($class) {
                case 'Altinv':
                    $action .= ' on Alternatives Investments';
                break;
                 case 'Client':
                    $action .= ' on Clients';
                break;
                case 'Comtrad':
                    $action .= ' on Commodities Trading';
                break;
                case 'Constru':
                    $action .= ' on Constructions';
                break;
                case 'FieldsComtrad':
                    $action .= ' on Fields Comtrad';
                break;            
                case 'Event':
                    $action .= ' on Events';
                break;
                case 'Rental':
                    $action .= ' on Rentals';
                break;
                case 'Todo':
                    $action .= ' on Tasks';
                break;
                case 'TrackAltinv':
                    $action .= ' on Track Alternatives Investments';
                break;
                case 'TrackComtrad':
                    $action .= ' on Track Commodities Trading';
                break;
                case 'TrackConstru':
                    $action .= ' on Track Constructions';
                break; 
                case 'TrackRental':
                    $action .= ' on Track Rentals';
                break; 
                case 'TypeAltinv':
                    $action .= ' on Type Alternatives Investments';
                break; 
                case 'TypeComtrad':
                    $action .= ' on Type Commodities Trading';
                break;
                case 'TypeConstru':
                    $action .= ' on Type Constructions';
                break;
                case 'TypeRental':
                    $action .= ' on Type Rentals';
                break; 
                case 'Todo':
                    $action .= ' on Tasks';
                break;             
                case 'Usuario':
                    $action .= ' on Users';
                break;            
            }
            $logActivity->setAction($action);
        }

        return $this->render('logactivity/index.html.twig', array(
            'logActivities' => $logActivities,
        ));
    }

    /**
     * Creates a new LogActivity entity.
     *
     * @Route("/new", name="logactivity_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $logActivity = new LogActivity();
        $form = $this->createForm('BL\SGIBundle\Form\LogActivityType', $logActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logActivity);
            $em->flush();

            return $this->redirectToRoute('logactivity_show', array('id' => $logactivity->getId()));
        }

        return $this->render('logactivity/new.html.twig', array(
            'logActivity' => $logActivity,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/log", name="log_list")
     * @Method("GET")
     */
    public function logAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');

        /*$user = $userManager->findUserByUsername($this->container->get('security.context')
                    ->getToken()
                    ->getUser());

        $usuario = $user->getUsername();*/
        $user=$this->getUser();
        
        // Obtengo el grupo de mi usuario
        $grupo_usuario = $user->getGroupNames();
        $grupo_usuario = $grupo_usuario[0]; 
        
        $em = $this->getDoctrine()->getManager();
        $event = '';
        
        // Mostrar en la vista si es admin defaul value true
        $show = true;
        
        if ($grupo_usuario == 'Administrator') {
            $results = $em
               ->createQuery('SELECT e FROM SGIBundle:LogActivity e'
                       . ' ORDER BY e.loggedAt DESC')
               ->setMaxResults(5)     
               ->getResult();            

        }  else {  
            $results = 0;
        }      
        
        // Numero de logs (badge)
        $number_log = count($results);        
        
        
        // Enlace al listado de Eventos
        $link_all = $this->generateUrl('logactivity_index', array());        
 
        // Listado de eventos
        $all_log = '
                    <h3>
                         &nbsp;&nbsp;&nbsp;&nbsp;</h3>
                        <a href="'.$link_all.'">view all</a>
                    </li>';        
        
        $calendar_log = '';

        if ($grupo_usuario == 'Administrator') {
                if (count($results) > 0) {
                   foreach($results as $result) {

                        // Listado de log
                        // Definir acción
                        $operation = $result->getAction();
                        $table = strtolower($result->getObjectClass());
                        
                        $usuario = $result->getUserid()->getNombre().' '.$result->getUserid()->getApellido();            
                        
                        $action = '';
                        $class = $result->getObjectClass();
                            switch ($class) {
                                case 'Altinv':
                                    $action .= ' on Alternatives Investments';
                                break;
                                 case 'Client':
                                    $action .= ' on Clients';
                                break;
                                case 'Comtrad':
                                    $action .= ' on Commodities Trading';
                                break;
                                case 'Constru':
                                    $action .= ' on Constructions';
                                break;
                                case 'FieldsComtrad':
                                    $action .= ' on Fields Comtrad';
                                break;            
                                case 'Event':
                                    $action .= ' on Events';
                                break;
                                case 'Rental':
                                    $action .= ' on Rentals';
                                break;
                                case 'Todo':
                                    $action .= ' on Tasks';
                                break;
                                case 'TrackAltinv':
                                    $action .= ' on Track Alternatives Investments';
                                break;
                                case 'TrackComtrad':
                                    $action .= ' on Track Commodities Trading';
                                break;
                                case 'TrackConstru':
                                    $action .= ' on Track Constructions';
                                break; 
                                case 'TrackRental':
                                    $action .= ' on Track Rentals';
                                break; 
                                case 'TypeAltinv':
                                    $action .= ' on Type Alternatives Investments';
                                break; 
                                case 'TypeComtrad':
                                    $action .= ' on Type Commodities Trading';
                                break;
                                case 'TypeConstru':
                                    $action .= ' on Type Constructions';
                                break;
                                case 'TypeRental':
                                    $action .= ' on Type Rentals';
                                break;            
                                case 'Usuario':
                                    $action .= ' on Users';
                                break;            
                            }
                        
                        switch ($operation) {
                            case 'Insert':
                                $label = 'label-success';
                                $icon = 'icon-plus';
                                $link = $this->generateUrl($table.'_show', array('id' => $result->getObjectId()));
                                $inicio = '<a href="'.$link.'">';
                                $cierre = '</a href="'.$link.'">';
                                $desc = 'Insert into '.$action.' by '.$usuario;
                                break;
                            case 'Update':
                                $label = 'label-info';
                                $icon = 'icon-pencil';
                                $link = $this->generateUrl($table.'_show', array('id' => $result->getObjectId()));
                                $inicio = '<a href="'.$link.'">';
                                $desc = 'Update into '.$action.' by '.$usuario;
                                break;
                            case 'Delete':
                                $label = 'label-danger';
                                $icon = 'icon-trash';
                                $link = $this->generateUrl($table.'_index', array());
                                $desc = 'Delete into '.$action.' by '.$usuario;
                                break;
                        }    

                        if ($grupo_usuario == 'Administrator') {

                                $usuario = $result->getUserid()->getNombre().' '.$result->getUserid()->getApellido();            
                                $fecha = $result->getLoggedAt()->format('Y-m-d h:i:s');
                                $calendar_log .= '
                                            <li>
                                                <a href="'.$link.'">
                                                    <span class="task">
                                                        <span class="desc"><span class="label label-sm label-icon '.$label.'">
                                                        <i class="'.$icon.'">&nbsp;</i></span>
                                                        <span class="desc" sytle="text-align: justify;">'.$desc.' ('.$fecha.')</span>    
                                                    </span>
                                                    </hr>
                                                </a>
                                            </li>';
                        } 
                   }
                } 
                
                
        } else {
            $show = false;
        }    
        // Cierre de Estructuras
        $calendar_log .= '</ul>
                        </li>
                    </ul>';   
        
        $arreglo = array();
            $arreglo[] = array(                   
              //  "number" => $number_log,
                "all" => $all_log,
                "calendar" => $calendar_log,
                "show" => $show
            );         
        
        
        return new JsonResponse($arreglo);
        
    }            
        
    
    /**
     *
     * @Route("/log_box", name="log_box")
     * @Method("GET")
     */
    public function logboxAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');

       /* $user = $userManager->findUserByUsername($this->container->get('security.context')
                    ->getToken()
                    ->getUser());

        $usuario = $user->getUsername();
        */
        $user=$this->getUser();
        // Obtengo el grupo de mi usuario
        
        $grupo_usuario = $user->getGroupNames();
        $grupo_usuario = $grupo_usuario[0]; 
        
        $em = $this->getDoctrine()->getManager();
        $event = '';
        
        // Mostrar en la vista si es admin defaul value true
        $show = true;
        
        $type = $request->get('type');
        
        if ($grupo_usuario == 'Administrator') { 
            $results = $em
               ->createQuery('SELECT e FROM SGIBundle:LogActivity e'
                       . ' ORDER BY e.loggedAt DESC')
               ->setMaxResults(10)     
               ->getResult(); 
            
            // En caso de modificar el filtro por ajax se agrega este filtro
            if ($type == 'Insert' || $type == 'Update' || $type == 'Delete' ) {  
                $results = $em
                   ->createQuery('SELECT e FROM SGIBundle:LogActivity e'
                           . ' WHERE e.action = :action '
                           . ' ORDER BY e.loggedAt DESC')
                    ->setParameter('action', $type)
                    ->setMaxResults(10)     
                    ->getResult();                                 
            }
        }  else {  
            $results = 0;
        }                   
 
        // Listado de eventos
        $calendar_log = '';

        if ($grupo_usuario == 'Administrator') {
                if (count($results) > 0) {
                   foreach($results as $result) {

                        // Listado de log
                        // Definir acción
                        $operation = $result->getAction();
                        $table = strtolower($result->getObjectClass());
                        
                        $usuario = $result->getUserid()->getNombre().' '.$result->getUserid()->getApellido();            
                        
                        $action = '';
                        $class = $result->getObjectClass();
                            switch ($class) {
                                case 'Altinv':
                                    $action .= ' on Alternatives Investments';
                                break;
                                 case 'Client':
                                    $action .= ' on Clients';
                                break;
                                case 'Comtrad':
                                    $action .= ' on Commodities Trading';
                                break;
                                case 'Constru':
                                    $action .= ' on Constructions';
                                break;
                                case 'FieldsComtrad':
                                    $action .= ' on Fields Comtrad';
                                break;            
                                case 'Event':
                                    $action .= ' on Events';
                                break;
                                case 'Rental':
                                    $action .= ' on Rentals';
                                break;
                                case 'Todo':
                                    $action .= ' on Tasks';
                                break;
                                case 'TrackAltinv':
                                    $action .= ' on Track Alternatives Investments';
                                break;
                                case 'TrackComtrad':
                                    $action .= ' on Track Commodities Trading';
                                break;
                                case 'TrackConstru':
                                    $action .= ' on Track Constructions';
                                break; 
                                case 'TrackRental':
                                    $action .= ' on Track Rentals';
                                break; 
                                case 'TypeAltinv':
                                    $action .= ' on Type Alternatives Investments';
                                break; 
                                case 'TypeComtrad':
                                    $action .= ' on Type Commodities Trading';
                                break;
                                case 'TypeConstru':
                                    $action .= ' on Type Constructions';
                                break;
                                case 'TypeRental':
                                    $action .= ' on Type Rentals';
                                break;            
                                case 'Usuario':
                                    $action .= ' on Users';
                                break;            
                            }
                        
                        switch ($operation) {                        
                            case 'Insert':
                                $label = 'label-success';
                                $icon = 'icon-plus';
                                $link = $this->generateUrl($table.'_show', array('id' => $result->getObjectId()));
                                $inicio = '<a href="'.$link.'">';
                                $cierre = '</a href="'.$link.'">';
                                $desc = '<strong> Insert into '.$action.'</strong> by '.$usuario;
                                break;
                            case 'Update':
                                $label = 'label-info';
                                $icon = 'icon-pencil';
                                $link = $this->generateUrl($table.'_show', array('id' => $result->getObjectId()));
                                $inicio = '<a href="'.$link.'">';
                                $desc = '<strong> Update into '.$action.'</strong> by '.$usuario;
                                break;
                            case 'Delete':
                                $label = 'label-danger';
                                $icon = 'icon-trash';
                                $link = $this->generateUrl($table.'_index', array());
                                $desc = '<strong> Delete into '.$action.'</strong> by '.$usuario;
                                break;
                        }    

                        if ($grupo_usuario == 'Administrator') {

                                $usuario = $result->getUserid()->getNombre().' '.$result->getUserid()->getApellido();            
                                $fecha = $result->getLoggedAt()->format('Y-m-d h:i:s');
                                
                                $calendar_log .= '
                                                <li>
                                                <div class="col-sm-8">
                                                    <div class="cont">
                                                        <div class="col-sm-2">
                                                            <div class="label label-sm '.$label.'">
                                                                <i class="'.$icon.'">&nbsp;</i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="desc">'. $desc .'
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="date">'.$fecha.'</div>
                                                </div>
                                            </li>';
                                
                        } 
                   }
                } 
                
                
        } else {
            $show = false;
        }      
        
        $arreglo = array();
            $arreglo[] = array(                   
                "all" => $calendar_log,
                "show" => $show
            );         
        
        
        return new JsonResponse($arreglo);
        
    }     
    
    /**
     * Finds and displays a LogActivity entity.
     *
     * @Route("/{id}", name="logactivity_show")
     * @Method("GET")
     */
    public function showAction(LogActivity $logActivity)
    {
        $deleteForm = $this->createDeleteForm($logActivity);

        return $this->render('logactivity/show.html.twig', array(
            'logActivity' => $logActivity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LogActivity entity.
     *
     * @Route("/{id}/edit", name="logactivity_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LogActivity $logActivity)
    {
        $deleteForm = $this->createDeleteForm($logActivity);
        $editForm = $this->createForm('BL\SGIBundle\Form\LogActivityType', $logActivity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logActivity);
            $em->flush();

            return $this->redirectToRoute('logactivity_edit', array('id' => $logActivity->getId()));
        }

        return $this->render('logactivity/edit.html.twig', array(
            'logActivity' => $logActivity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LogActivity entity.
     *
     * @Route("/{id}", name="logactivity_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LogActivity $logActivity)
    {
        $form = $this->createDeleteForm($logActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($logActivity);
            $em->flush();
        }

        return $this->redirectToRoute('logactivity_index');
    }

    /**
     * Creates a form to delete a LogActivity entity.
     *
     * @param LogActivity $logActivity The LogActivity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LogActivity $logActivity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logactivity_delete', array('id' => $logActivity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

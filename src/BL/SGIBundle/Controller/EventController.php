<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Event;
use BL\SGIBundle\Form\EventType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * Lists all Event entities.
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('SGIBundle:Event')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     *
     * @Route("/calendar", name="event_list")
     * @Method("GET")
     */
    public function calendarAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($this->container->get('security.context')
                    ->getToken()
                    ->getUser());

        $usuario = $user->getUsername();
        
        // Obtengo el grupo de mi usuario
        $grupo_usuario = $user->getGroupNames();
        $grupo_usuario = $grupo_usuario[0]; 
        
        $em = $this->getDoctrine()->getManager();
        $event = '';
        
        if ($grupo_usuario == 'Administrator') {
            $results = $em
               ->createQuery('SELECT e FROM SGIBundle:Event e WHERE e.datetimeStart >= :now '
                       . 'or e.datetimeEnd >= :now ORDER BY e.datetimeStart ASC')
               ->setParameter('now', new \DateTime('now'))
                ->setMaxResults(5)     
               ->getResult();            

        }  else {
            $parameters = array(
                'now' => new \DateTime('now'), 
                'userid' => $user->getId()
            );
            $results = $em
               ->createQuery('SELECT e FROM SGIBundle:Event e WHERE (e.datetimeStart >= :now '
                       . 'or e.datetimeEnd >= :now) and e.userid = :userid '
                       . 'ORDER BY e.datetimeStart ASC')
               ->setParameters($parameters)
                ->setMaxResults(5)     
               ->getResult();            
            
        }      
        
        // Numero de eventos (badge)
        $number_events = count($results);        
        
        $event = 'events';
        if (count($results) == 1) {
            $event = 'event';
        }
        
        // Enlace al listado de Eventos
        $link_all = $this->generateUrl('event_index', array());        
 
        // Listado de eventos
        $all_events = '
                    <h3>You have
                        <span class="bold">'.count($results).' '.$event.'</span></h3>
                    <a href="'.$link_all.'">view all</a>
                    </li>';        
        
        $calendar_events = '';

        if (count($results) > 0) {
           foreach($results as $result) {
                
                $link_show = $this->generateUrl('event_show', array('id' => $result->getId()));               
                // Listado de eventos
                $calendar_events .= '
                            <li>
                                <a href="'.$link_show.'">
                                    <span class="task">
                                        <span class="desc"><span class="label label-sm label-icon label-success">
                                                        <i class="icon-clock"></i>
                                                    </span>&nbsp;&nbsp;<strong>'.$result->getDatetimeStart()->format('Y-m-d h:i:s').' (Start)</strong></span><br><br>
                                        <span class="desc"><span class="label label-sm label-icon label-danger">
                                                        <i class="icon-clock"></i>
                                                    </span>&nbsp;&nbsp;<strong>'.$result->getDatetimeEnd()->format('Y-m-d h:i:s').' (End)</strong></span><br><br>    
                                        <span class="desc" sytle="text-align: justify;">'.$result->getDescription().'</span>    
                                    </span>
                                    </hr>
                                </a>
                            </li>';
           }
        } else {
            $calendar_events = '<span class="desc">'
                    . '<center><br><br>'
                    . 'There are no events to display at this moment</center>'
                    . '</span>';
        }
            
        // Cierre de Estructuras
        $calendar_events .= '</ul>
                        </li>
                    </ul>';   
        
        $arreglo = array();
            $arreglo[] = array(                   
                "number" => $number_events,
                "all" => $all_events,
                "calendar" => $calendar_events,
            );         
        
        
        return new JsonResponse($arreglo);
        
    }    
    
    /**
     * Creates a new Event entity.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('BL\SGIBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Event x WHERE x.id = ?1');
            $query->setParameter(1, $event->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'Event', 
                            $event->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('event_show', array('id' => $event->getId()));
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     * @Route("/{id}", name="event_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('BL\SGIBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Event x WHERE x.id = ?1');
            $query->setParameter(1, $event->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'Event', 
                            $event->getId());
            */
            
            // fin proceso log             
            
            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Event x WHERE x.id = ?1');
            $query->setParameter(1, $event->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'Event', 
                            $event->getId());
            */
            
            // fin proceso log 
            
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a Event entity.
     *
     * @param Event $event The Event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
}

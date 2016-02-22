<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Todo;
use BL\SGIBundle\Form\TodoType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Todo controller.
 *
 * @Route("/todo")
 */
class TodoController extends Controller
{
    /**
     * Lists all Todo entities.
     *
     * @Route("/", name="todo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($this->container->get('security.context')
                    ->getToken()
                    ->getUser());

        $usuario = $user->getUsername();
        
        // Obtengo el grupo de mi usuario
        $grupo_usuario = $user->getGroupNames();
        $grupo_usuario = $grupo_usuario[0]; 
        
        if ($grupo_usuario == 'Administrator') {        
            $todos = $em->getRepository('SGIBundle:Todo')->findAll();
        } else {
            $todos = $em->getRepository('SGIBundle:Todo')->findBy(array('userid' => $user->getId()));
        }
        
        return $this->render('todo/index.html.twig', array(
            'todos' => $todos,
        ));
    }

    /**
     * Creates a new Todo entity.
     *
     * @Route("/new", name="todo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $todo = new Todo();
        $form = $this->createForm('BL\SGIBundle\Form\TodoType', $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Todo x WHERE x.id = ?1');
            $query->setParameter(1, $todo->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'Todo', 
                            $todo->getId());
            */
            
            // fin proceso log            
            
            // Redirecciono dependiendo de mi accion
            $action = $todo->getIdBl()->getType(); 
            return $this->redirectToRoute($action.'_index');
        }

        return $this->render('todo/new.html.twig', array(
            'todo' => $todo,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/task", name="todo_list")
     * @Method("GET")
     */
    public function taskAction()
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
               ->createQuery('SELECT e FROM SGIBundle:Todo e WHERE e.completed = :completed '
                       . 'ORDER BY e.idPriority ASC')
               ->setParameter('completed', false)
                ->setMaxResults(5)     
               ->getResult();            

        }  else {
            $parameters = array(
                'completed' => false, 
                'userid' => $user->getId()
            );
            $results = $em
               ->createQuery('SELECT e FROM SGIBundle:Todo e WHERE e.completed = :completed '
                       . 'and e.userid = :userid '
                       . 'ORDER BY e.idPriority ASC')
               ->setParameters($parameters)
                ->setMaxResults(5)     
               ->getResult();            
            
        }      
        
        // Numero de tareas (badge)
        $number_todo = count($results);        
        
        $task = 'tasks';
        if (count($results) == 1) {
            $task = 'task';
        }
        
        // Enlace al listado de Eventos
        $link_all = $this->generateUrl('todo_index', array());        
 
        // Listado de eventos
        $all_todo = '
                    <h3>You have
                        <span class="bold">'.count($results).' '.$task.'</span></h3>
                    <a href="'.$link_all.'">view all</a>
                    </li>';        
        
        $calendar_todo = '';

        if (count($results) > 0) {
           foreach($results as $result) {
                
                $link_show = $this->generateUrl('todo_show', array('id' => $result->getId()));               
                // Listado de eventos
                
                // Definir color de la prioridad
                $priority = $result->getIdPriority()->getDescription();

                switch ($priority) {
                    case 'High':
                        $label = 'label-danger';
                        break;
                    case 'Medium':
                        $label = 'label-warning';
                        break;
                    case 'Low':
                        $label = 'label-primary';
                        break;
                }    
                
                if ($grupo_usuario == 'Administrator') {
                    
                        $usuario = $result->getUserid()->getNombre().' '.$result->getUserid()->getApellido();            
                        
                        $calendar_todo .= '
                                    <li>
                                        <a href="'.$link_show.'">
                                            <span class="task">
                                                <span class="desc"><span class="label label-sm label-icon '.$label.'">
                                                <i class="icon-pin"></i>
                                                </span>&nbsp;&nbsp;<strong> Assigned to: '.$usuario.'</strong></span><br><br>
                                                <span class="desc" sytle="text-align: justify;">'.$result->getDescription().'</span>    
                                            </span>
                                            </hr>
                                        </a>
                                    </li>';
                } else {
                        $calendar_todo .= '
                                    <li>
                                        <a href="'.$link_show.'">
                                            <span class="task">
                                                <span class="desc"><span class="label label-sm label-icon '.$label.'">
                                                <i class="icon-pin">&nbsp;</i>&nbsp;</span>
                                                <span class="desc" sytle="text-align: justify;">'.$result->getDescription().'</span>    
                                            </span>
                                            </hr>
                                        </a>
                                    </li>';                   
                }
           }
        } else {
            $calendar_todo = '<span class="desc">'
                    . '<center><br><br>'
                    . 'There are no events to display at this moment</center>'
                    . '</span>';
        }
            
        // Cierre de Estructuras
        $calendar_todo .= '</ul>
                        </li>
                    </ul>';   
        
        $arreglo = array();
            $arreglo[] = array(                   
                "number" => $number_todo,
                "all" => $all_todo,
                "calendar" => $calendar_todo,
            );         
        
        
        return new JsonResponse($arreglo);
        
    }            
    
    
    /**
     * Finds and displays a Todo entity.
     *
     * @Route("/{id}", name="todo_show")
     * @Method("GET")
     */
    public function showAction(Todo $todo)
    {
        $deleteForm = $this->createDeleteForm($todo);

        return $this->render('todo/show.html.twig', array(
            'todo' => $todo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Todo entity.
     *
     * @Route("/{id}/edit", name="todo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Todo $todo)
    {
        $deleteForm = $this->createDeleteForm($todo);
        $editForm = $this->createForm('BL\SGIBundle\Form\TodoType', $todo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Todo x WHERE x.id = ?1');
            $query->setParameter(1, $todo->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'Todo', 
                            $todo->getId());
            */
            
            // fin proceso log            
            
            return $this->redirectToRoute('todo_edit', array('id' => $todo->getId()));
        }

        return $this->render('todo/edit.html.twig', array(
            'todo' => $todo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comtrad entity.
     *
     * @Route("/delete/{id}", name="todo_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $todos = $em->getRepository('SGIBundle:Todo')
                    ->findBy(array('id'=> $id));
        
        if (count($todos) > 0) {
            foreach($todos as $todo) {
                
                // Procedo log
                /*
                $userManager = $this->container->get('fos_user.user_manager');

                $user = $userManager->findUserByUsername($this->container->get('security.context')
                                ->getToken()
                                ->getUser());


                $query = $em->createQuery('SELECT x FROM SGIBundle:Todo x WHERE x.id = ?1');
                $query->setParameter(1, $todo->getId());
                $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

                $bitacora = $em->getRepository('SGIBundle:LogActivity')
                        ->bitacora($user->getId(), 'Delete', 'Todo', 
                                $todo->getId());
                */

                // fin proceso log                 
                
                $em->remove($todo);
                $em->flush();           
            }
        }
             
        return $this->redirectToRoute('todo_index');
    }

    /**
     * Creates a form to delete a Todo entity.
     *
     * @param Todo $todo The Todo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Todo $todo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('todo_delete', array('id' => $todo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    

}

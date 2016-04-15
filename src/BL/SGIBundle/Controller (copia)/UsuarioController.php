<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use BL\SGIBundle\Entity\Usuario;
use BL\SGIBundle\Form\UsuarioType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        // Elaboro los botones
        $link_new = $this->generateUrl('usuario_new', array());
                
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserByUsername($this->container->get('security.context')
                    ->getToken()
                    ->getUser());

        $usuario = $user->getUsername();
        
        // Obtengo el grupo de mi usuario
        $grupo_usuario = $user->getGroupNames();
        $grupo_usuario = $grupo_usuario[0];        
            
        // Asigno los botones según mi grupo
        switch ($grupo_usuario) {
            case "Administrador":
                $new = '<a href = "'.$link_new.'" class = "btn btn-success btn-sm"><span class = "glyphicon glyphicon-plus"></span> Agregar</a>';
                break;
            default:
                $new = '';
                break;
            
        }
        
        return array(
            'new' => $new,
        ); 
    }
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/", name="usuario_create")
     * @Method("POST")
     * @Template("SGIBundle:Usuario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $usuario = $request->get('sgi_siretrabundle_usuario');
        $grupos = $usuario['grupo'];
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $em2 = $this->getDoctrine()->getEntityManager('reportasistencia');
            $connection = $em2->getConnection();
            $statement = $connection->prepare("SELECT * FROM userinfo WHERE dbi like :dbi");
            $statement->bindValue('dbi', $entity->getDni());
            $statement->execute();
            $results = $statement->fetchAll();
            if (count($results) > 0) {
                $userid = $results[0]["userid"];
                $entity->setIdUserinfo($userid);
                $em->persist($entity);
                $em->flush();   
            }            

            for($i=0;$i < count($grupos);$i++) {
                $entity_group = $em->getRepository('SGIBundle:Group')->find($grupos[$i]);
                $entity->addGroup($entity_group);
                $em->persist($entity);
                $em->flush();            
            } 
            
            $id = $entity->getId();
            // Procedo log
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                        ->getToken()
                        ->getUser());

            $usuario = $user->getUsername();

            $query = $em->createQuery('SELECT x FROM SGIBundle:Usuario x WHERE x.id = ?1');
            $query->setParameter(1, $id);
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);
            
            $bitacora = $em->getRepository('SGIBundle:ExtLogEntries')
                    ->bitacora($usuario,'Insert','Usuario',$entity->getId(),$arreglo_formulario);
               
            // fin proceso log             
            
            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
            'method' => 'POST',
        ));
        
        
        $groups = $this->container->get('fos_user.group_manager')->findGroups();
        foreach ($groups as $grupo) {
            $grupos[$grupo->getId()] = $grupo->getName();
        }

        $form->add('grupo', 'choice', array(
            'attr' => array('class' => 'form-control'),
            'choices' => $grupos,
            'multiple' => true,
            'mapped' => false,
        ));      
        
        $form->add('submit', 'submit', array('label' => 'Enviar',
            'attr' => array('class' => 'btn btn-success btn-sm center-block')
                )
        );
        
        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="usuario_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SGIBundle:Usuario')->find($id);
        

        $activo = ($entity->IsEnabled()) ? "Sí" : "No";
        
            // Obtengo todos los grupos previos de mi usuario
            $grupos_usuario = $entity->getGroupNames();
            
            // Busco cada grupo
            for ($i=0; $i < count($grupos_usuario); $i++) { 
                $entity_grupo = $this->container->get('fos_user.group_manager')->
                    findGroupBy(array('name' => $grupos_usuario[$i])); 
                // Por cada grupo que consiga lo elimino
                $entity_group = $em->getRepository('SGIBundle:Group')->find($entity_grupo->getId());
                $grupo = $entity_group->getName();
            }        
        
        $usuario = array(                
                "dbi" => $entity->getDni(),
                "nacionalidad" => $entity->getNacionalidad(),
                "nombre" => $entity->getNombre(),
                "apellido" => $entity->getApellido(),
                "telefono" => $entity->getTelefono(),
                "telefono_secundario" => $entity->getTelefonoSecundario(),           
		"username" => $entity->getUsername(),
		"email" => $entity->getEmail(),
                "activo" => $activo,
                "grupo" => $grupo,
        );
        
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($this->container->get('security.context')
                        ->getToken()
                        ->getUser());
        
        // Obtengo el grupo de mi usuario
       // $grupo_usuario = $user->getGroupNames();
         $grupo_usuario = 1;
        $grupo_usuario = $grupo_usuario[0];
        
        // Elaboro los botones
        $link_index = $this->generateUrl('usuario', array());
        $link_show = $this->generateUrl('usuario_show', array('id' => $id));
        $link_edit = $this->generateUrl('usuario_edit', array('id' => $id));
        $link_delete = $this->generateUrl('usuario_delete', array('id' => $id));
        $index = '<a href = "'.$link_index.'" class = "btn btn-info btn-sm"><span class = "glyphicon glyphicon-th-list"></span> Listado</a>';
        $show = '<a href = "'.$link_show.'" class = "btn btn-info btn-sm"><span class = "glyphicon glyphicon glyphicon-search"></span> Ver</a>';
        $edit = '<a href = "'.$link_edit.'" class = "btn btn-info btn-sm"><span class = "glyphicon glyphicon-edit"></span> Editar</a>';
        $delete = '<a id="eliminar" href = "'.$link_delete.'" class = "btn btn-danger btn-sm"><span class = "glyphicon glyphicon glyphicon-alert"></span> Desactivar</a>';

        // Asigno los botones según mi grupo
        // Asigno los botones según mi grupo
        switch ($grupo_usuario) {
            case "Administrador":
                $botones = $index.' '.$show.' '.$edit.' '.$delete;
                break;
            case "Usuario Extendido":
                if ($id == $user->getId()) {                    
                    $botones = $index.' '.$show.' '.$edit;
                } else {
                    $botones = $index.' '.$show;
                }                
                break;
            default:
                $botones = $index.' '.$show;
                break;
        }        
                      
        return array(
            'usuario' => $usuario, 'botones' => $botones
        ); 
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SGIBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $groups = $this->container->get('fos_user.group_manager')->findGroups();
        foreach ($groups as $grupo) {
            $grupos[$grupo->getId()] = $grupo->getName();
        }
        
        
        // Obtengo todos los grupos de mi usuario
        $grupos_usuario = $entity->getGroupNames();
        // Busco cada grupo
        for ($i=0; $i < count($grupos_usuario); $i++) {
            $entity_grupo = $this->container->get('fos_user.group_manager')->
                    findGroupBy(array('name' => $grupos_usuario[$i])); 
            // Construyo el arreglo por id para que en el choice puedan aparecer como 
            // selected
            $grupo_existente[$entity_grupo->getId()] = $entity_grupo->getId();
        }
        
        $form->add('grupo', 'choice', array(
            'attr' => array('class' => 'form-control'),
            'choices' => $grupos,
            'multiple' => true,
            'mapped' => false,
             'data' => $grupo_existente,            
        ));    
        
        $form->add('submit', 'submit', array('label' => 'Enviar',
            'attr' => array('class' => 'btn btn-success btn-sm center-block')
                )
        );
        
        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}", name="usuario_update")
     * @Method("PUT")
     * @Template("SGIBundle:Usuario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('SGIBundle:Usuario')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
                          
        if ($editForm->isValid()) {
            $em->flush();
  
            // Eliminar los grupos previamente incluidos para este usuario y realizar
            // la nueva insercion correspondiente
            
            // Obtengo todos los grupos previos de mi usuario
            $grupos_usuario = $entity->getGroupNames();
            
            // Busco cada grupo
            for ($i=0; $i < count($grupos_usuario); $i++) { 
                $entity_grupo = $this->container->get('fos_user.group_manager')->
                    findGroupBy(array('name' => $grupos_usuario[$i])); 
                // Por cada grupo que consiga lo elimino
                $entity_group = $em->getRepository('SGIBundle:Group')->find($entity_grupo->getId());
                $entity->getGroups()->removeElement($entity_group);
                $em->persist($entity);
                $em->flush();
            }
 
            // Obtengo los grupos que voy a asignarle al usuario
            $usuario = $request->get('sgi_siretrabundle_usuario');
            $grupos = $usuario['grupo'];
            
            for($i=0;$i < count($grupos);$i++) {
                $entity_group = $em->getRepository('SGIBundle:Group')->find($grupos[$i]);
                $entity->addGroup($entity_group);
                $em->persist($entity);
                $em->flush();            
            }             
            
	    // Proceso Log
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                        ->getToken()
                        ->getUser());

            $usuario = $user->getUsername();

            $query = $em->createQuery('SELECT x FROM SGIBundle:Usuario x WHERE x.id = ?1');
            $query->setParameter(1, $id);
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);
            
            $bitacora = $em->getRepository('SGIBundle:ExtLogEntries')
                    ->bitacora($usuario,'Update','Usuario',$entity->getId(),$arreglo_formulario);
            
            // fin proceso log
            
            return $this->redirect($this->generateUrl('usuario', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Usuario entity.
     *
     * @Route("/delete/{id}", name="usuario_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SGIBundle:Usuario')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

	    // Proceso Log
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                        ->getToken()
                        ->getUser());

            $usuario = $user->getUsername();

            $query = $em->createQuery('SELECT x FROM SGIBundle:Usuario x WHERE x.id = ?1');
            $query->setParameter(1, $id);
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);
                        
            $bitacora = $em->getRepository('SGIBundle:ExtLogEntries')
                    ->bitacora($usuario,'Update','Usuario',$entity->getId(),$arreglo_formulario);
  
            // fin proceso log
            
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }         
            $password = implode($pass);
            $query = $em->createQuery('update SGIBundle:Usuario u set u.enabled = ?2, u.password = ?3 where u.id = ?1');
            $query->setParameter(1, $id);
            $query->setParameter(2, 'false');
            $query->setParameter(3, $password);
            $query->getSingleResult(Query::HYDRATE_ARRAY);            

        return $this->redirect($this->generateUrl('usuario'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Creates a new Marca entity.
     *
     * @Route("/ajax/index", name="usuario_ajax")
     */
    public function ajaxAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SGIBundle:Usuario')->findBy(array(), array('dbi'=>'asc'));

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($this->container->get('security.context')
                        ->getToken()
                        ->getUser());
                   
        // Obtengo el grupo de mi usuario
        $grupo_usuario = $user->getGroupNames();
        $grupo_usuario = $grupo_usuario[0];
                
      
        $data = array();
        $dbi = array();
        $nombre = array();
        $apellido = array();
        $telefono = array();
        $telefono_secundario = array();
        $username = array();
        $email = array();
        $activo = array();
        $tipo = array();
        $botones_array = array();

        foreach ($entities as $list) {
            // Obtengo todos los grupos previos de mi usuario
            $grupos_usuario = $list->getGroupNames();
            
            // Busco cada grupo
            for ($i=0; $i < count($grupos_usuario); $i++) { 
                $entity_grupo = $this->container->get('fos_user.group_manager')->
                    findGroupBy(array('name' => $grupos_usuario[$i])); 
                // Por cada grupo que consiga lo elimino
                $entity_group = $em->getRepository('SGIBundle:Group')->find($entity_grupo->getId());
                $grupo = $entity_group->getName();
            }            
            $activo_usu = ($list->IsEnabled()) ? "Sí" : "No";
            $dbi_usu = $list->getNacionalidad().$list->getDni(); 
            array_push($dbi, $dbi_usu);
            array_push($nombre, $list->getNombre());
            array_push($apellido, $list->getApellido());
            array_push($telefono, $list->getTelefono());
            array_push($telefono_secundario, $list->getTelefonoSecundario());
            array_push($username, $list->getUsername());
            array_push($email, $list->getEmail());
            array_push($activo, $activo_usu); 
            array_push($tipo, $grupo);
            // Elaboro los botones
                $link_show = $this->generateUrl('usuario_show', array('id' => $list->getId()));
                $link_edit = $this->generateUrl('usuario_edit', array('id' => $list->getId()));
                $show = '<a href = "'.$link_show.'" data-toggle="tooltip" title="Ver"><span class = "glyphicon glyphicon glyphicon-search"></a>&nbsp;&nbsp;&nbsp;';
                $edit = '<a href = "'.$link_edit.'" data-toggle="tooltip" title="Editar"><span class = "glyphicon glyphicon glyphicon-edit"></a>';
                // Asigno los botones según mi grupo
                switch ($grupo_usuario) {
                    case "Administrador":
                        $botones = $show.' '.$edit;
                        break;
                    case "Usuario Extendido":
                        $botones = $show;
                        break;
                    default:
                        $botones = $show;
                        break;
                }
                if ($list->getId() == $user->getId() && $grupo_usuario != 'Usuario') {
                     $botones = $show.' '.$edit;
                }
                array_push($botones_array, htmlentities($botones));

        }
                
            $k = 0;
            for ($i = 0; $i < count($dbi); $i++) {
                              
                $row = array();
                $row["dbi"] = $dbi[$k];
                $row["nombre"] = $nombre[$k];
                $row["apellido"] = $apellido[$k];
                $row["telefono"] = $telefono[$k];
                $row["telefono_secundario"] = $telefono_secundario[$k];
                $row["username"] = $username[$k];
                $row["email"] = $email[$k];
                $row["activo"] = $activo[$k];
                $row["tipo"] = $tipo[$k];
                $row["botones"] = html_entity_decode($botones_array[$k]);
                $data[$i] = $row;
                $k++;
            }
        
        
                                
        return new JsonResponse($data);
    }    
    
    
    
}

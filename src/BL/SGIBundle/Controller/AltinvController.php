<?php

namespace BL\SGIBundle\Controller;

use BL\SGIBundle\Entity\TypeAltinv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Altinv;
use BL\SGIBundle\Form\AltinvType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;
use BL\SGIBundle\Entity\BlAltinv;
use Symfony\Component\Validator\Constraints\DateTime;
use BL\SGIBundle\Entity\Bl;


/**
 * Altinv controller.
 *
 * @Route("/altinv")
 */
class AltinvController extends Controller
{
    /**
     * Lists all Altinv entities.
     *
     * @Route("/", name="altinv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $altinvs = $em->getRepository('SGIBundle:Altinv')->findAll();
        $typeAltinvs = $em->getRepository('SGIBundle:TypeAltinv')->findAll();
        return $this->render('altinv/index.html.twig', array(
            'altinvs' => $altinvs, 'typeAltinvs' => $typeAltinvs
        ));
    }

    
    
      /**
     * Lists all Altinv entities by type.
     *
     * @Route("/indexbytype/{type}", name="altinv_indexbytype")
     * @Method("GET")
     */
    public function indexbytypeAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
        $type=$request->get('type');
        $altinvs = $em->getRepository('SGIBundle:Altinv')->findByIdTypeAltinv($type);
        $typeAltinvs = $em->getRepository('SGIBundle:TypeAltinv')->findById($type);
        return $this->render('altinv/index.html.twig', array(
            'altinvs' => $altinvs, 'typeAltinvs' => $typeAltinvs
        ));
    }
    
      /**
     * Lists one  Altinv dashboard.
     *
     * @Route("/dashboard/{id}", name="altinv_dashboard")
     * @Method("GET")
     */
    public function dashboardAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $altinvs = $em->getRepository('SGIBundle:Altinv')->findOneById($id);
        $type=$altinvs->getIdTypeAltinv();
        $typeAltinvs = $em->getRepository('SGIBundle:TypeAltinv')->findById($type);
        
        return $this->render('altinv/index.html.twig', array(
            'altinvs' => $altinvs, 'typeAltinvs' => $typeAltinvs
        ));
    }
    
    
    
    /**
     * Lists all Altinv entities.
     *
     * @Route("/list", name="altinv_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $altinvs = $em->getRepository('SGIBundle:Altinv')->findAll();

        return $this->render('altinv/list.html.twig', array(
            'altinvs' => $altinvs,
        ));
    }

    /**
     * Create Altinv Type entities.
     *
     * @Route("/add", name="ajax_typealtinv_create")
     * @Method("POST")
     */
    public function ajaxCreateAltinv(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new TypeAltinv();
        $object->setDescription( $request->get('description') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }

   

    /**
     * Creates a new Altinv entity.
     *
     * @Route("/new", name="altinv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $altinv = new Altinv();
        $form = $this->createForm('BL\SGIBundle\Form\AltinvType', $altinv);

        $entities = $em->getRepository('SGIBundle:FieldsAltinv')
            ->findBy(
                array('trackable'=> false),
                array('id' => 'ASC')
            );


        foreach ($entities as $entity) {

            // Reemplazar los espacios en blanco
            $desc = str_replace(" ","_",$entity->getDescription());
            switch ($entity->getWidget()) {
                case 'Calendar':
                    $form->add('EF-'.$desc, 'date', array(
                        'widget' => 'single_text',
                        'format' => 'dd-MM-yyyy',
                        'attr' => array(
                            'class' => 'form-control datepicker',
                            'data-provide' => 'datepicker',
                            'data-date-format' => 'dd-mm-yyyy'
                        ),
                        'mapped' => false,
                        'required' => false,
                        'label' => $desc,
                    ));
                    break;
                case 'Characters':
                    $form->add('EF-'.$desc,'text', array(
                        'mapped' => false,
                        'attr' => array('class' => 'form-control input-sm'),
                        'label' => $desc,
                        'required' => false,
                    ));
                    break;
                case 'Currency':
                    $form->add('EF-'.$desc,'text', array(
                        'mapped' => false,
                        'attr' => array('class' => 'form-control input-sm currency'),
                        'label' => $desc,
                        'required' => false,
                    ));
                    break;
                case 'File':
                    $form->add('EF-'.$desc,'file', array(
                        'mapped' => false,
                        'label' => $desc,
                        'required' => false,
                    ));
                    break;
                case 'Numeric':
                    $form->add('EF-'.$desc,'number', array(
                        'mapped' => false,
                        'attr' => array('class' => 'form-control input-sm numeric'),
                        'label' => $desc,
                        'required' => false,
                    ));
                    break;
                case 'TextArea':
                    $form->add('EF-'.$desc,'textarea', array(
                        'mapped' => false,
                        'attr' => array('class' => 'form-control input-sm'),
                        'label' => $desc,
                        'required' => false,
                    ));
                    break;
            }

        }


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($altinv);
            $em->flush();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Altinv x WHERE x.id = ?1');
            $query->setParameter(1, $altinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'Altinv', 
                            $altinv->getId());
            */
            
            // fin proceso log             
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_altinv
            $id = $altinv->getId();

            $arreglo = $_POST['altinv'];

            // Obtengo unicamente los elementos extra
            foreach ($arreglo as $key => $value) {
                if (strpos($key, 'EF-') !== 0) {
                    unset($arreglo[$key]);
                }
            }

            // Procedo a buscar mi campo dentro de la tabla fields
            foreach ($arreglo as $key => $value) {
                $key2 = str_replace("_"," ",$key);
                $key2 = str_replace("EF-","",$key2);

                $field = $em->getRepository('SGIBundle:FieldsAltinv')
                    ->findBy(array('description' => $key2));

                $getid_field = $field[0]->getId();


                $bl_altinv = new BlAltinv();

                $id_altinv = $em->getReference
                ('BL\SGIBundle\Entity\Altinv', $id);


                $id_field = $em->getReference
                ('BL\SGIBundle\Entity\FieldsAltinv', $getid_field);

                if (trim($value) != '') {
                    $bl_altinv->setIdAltinv($id_altinv);
                    $bl_altinv->setIdField($id_field);
                    $bl_altinv->setValue($value);
                    $em->persist($bl_altinv);
                    $em->flush();
                }
            }

            // Inserto la Bl
            $bl= new Bl();
            $bl->setCodeBl($id);
            $bl->setType('altinv');
            $bl->setDescription($altinv->getDescription());
            $em->persist($bl); 
            $em->flush();  
            
            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['altinv']['name']);

                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }

                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/altinv/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }

                $arreglo_archivos_name = $arreglo_archivos['altinv']['name'];


                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {

                    $file_name = $arreglo_archivos['altinv']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {

                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['altinv']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['altinv']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2);

                        $field = $em->getRepository('SGIBundle:FieldsAltinv')
                            ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        $bl_altinv = new BlAltinv();

                        $id_altinv = $em->getReference
                        ('BL\SGIBundle\Entity\Altinv', $id);


                        $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsAltinv', $getid_field);


                        $bl_altinv->setIdAltinv($id_altinv);
                        $bl_altinv->setIdField($id_field);
                        $bl_altinv->setValue($destination);
                        $em->persist($bl_altinv);
                        $em->flush();

                        $i++;

                    }
                }
            }

            $altinvs = $em->getRepository('SGIBundle:Altinv')->findAll();
             $typeAltinvs = $em->getRepository('SGIBundle:TypeAltinv')->findAll();
             
            return $this->render('altinv/index.html.twig', array(
                'altinvs' => $altinvs, 'typeAltinvs' => $typeAltinvs,
            ));


        }

        return $this->render('altinv/new.html.twig', array(
            'altinv' => $altinv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Altinv entity.
     *
     * @Route("/{id}", name="altinv_show")
     * @Method("GET")
     */
    public function showAction(Altinv $altinv)
    {
        $deleteForm = $this->createDeleteForm($altinv);

        return $this->render('altinv/show.html.twig', array(
            'altinv' => $altinv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Altinv entity.
     *
     * @Route("/{id}/edit", name="altinv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Altinv $altinv)
    {
        $deleteForm = $this->createDeleteForm($altinv);
        $editForm = $this->createForm('BL\SGIBundle\Form\AltinvType', $altinv);

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SGIBundle:FieldsAltinv')
                    ->findBy(
                        array('trackable'=> false), 
                        array('id' => 'ASC')    
                     );
        if (count($entities) > 0) {
            foreach ($entities as $entity) {
            
                // Reemplazar los espacios en blanco
                $desc = str_replace(" ","_",$entity->getDescription());            

                $bl_altinv = $em->getRepository('SGIBundle:BlAltinv')
                                ->findOneBy(
                                    array('idField'=> $entity->getId(),'idAltinv' => $altinv->getId()) 
                                 );       
                        
                
                    switch ($entity->getWidget()) {

                        case 'Calendar':
                            if (count($bl_altinv) > 0) {
                                $value = $bl_altinv->getValue();
                                $date = new \DateTime($value);

                                $editForm->add('EF-'.$desc, 'date', array(
                                    'widget' => 'single_text',
                                    'format' => 'dd-MM-yyyy',
                                    'attr' => array(
                                        'class' => 'form-control datepicker',
                                        'data-provide' => 'datepicker',
                                        'data-date-format' => 'dd-mm-yyyy'
                                    ),
                                    'mapped' => false,
                                    'label' => $desc, 
                                    'required' => false,
                                    'data' => $date, 
                                ));                                 
                            } else {
                                $editForm->add('EF-'.$desc, 'date', array(
                                    'widget' => 'single_text',
                                    'format' => 'dd-MM-yyyy',
                                    'attr' => [
                                        'class' => 'form-control datepicker',
                                        'data-provide' => 'datepicker',
                                        'data-date-format' => 'dd-mm-yyyy'
                                    ],
                                    'mapped' => false,
                                    'label' => $desc, 
                                    'required' => false,
                                ));
                            }                      
                            break;
                        case 'Characters':
                            if (count($bl_altinv) > 0) {
                                $value = $bl_altinv->getValue();
                                $editForm->add('EF-'.$desc,'text', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm'),
                                    'label' => $desc, 
                                    'data' => $value, 
                                    'required' => false,
                                ));                                
                            } else {
                                 $editForm->add('EF-'.$desc,'text', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm'),
                                    'label' => $desc, 
                                    'required' => false,
                                ));                                
                            }

                            break;
                        case 'Currency':
                            if (count($bl_altinv) > 0) {
                                $value = $bl_altinv->getValue();
                                $editForm->add('EF-'.$desc,'text', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm currency'),
                                    'label' => $desc,
                                    'data' => $value,
                                    'required' => false,
                                ));                                
                            } else {
                                $editForm->add('EF-'.$desc,'number', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm currency'),
                                    'label' => $desc,
                                    'required' => false,
                                ));                                
                            }
                            break;
                        case 'File':
                            if (count($bl_altinv) > 0) {
                                $value = $bl_altinv->getValue(); 
                                $editForm->add('EF-'.$desc,'file', array(
                                    'mapped' => false,
                                    'label' => $desc,
                                    'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                                    'required' => false,
                                ));                               
                            } else {
                                $editForm->add('EF-'.$desc,'file', array(
                                    'mapped' => false,
                                    'label' => $desc,
                                    'required' => false,
                                ));                                
                            }
                            break; 
                        case 'Numeric':
                            if (count($bl_altinv) > 0) {
                                $value = $bl_altinv->getValue();
                                $editForm->add('EF-'.$desc,'number', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm numeric'),
                                    'label' => $desc, 
                                    'data' => $value, 
                                    'required' => false,
                                ));                                
                            } else {
                                $editForm->add('EF-'.$desc,'number', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm numeric'),
                                    'label' => $desc, 
                                    'required' => false,
                                ));                                
                            }
                            break;
                        case 'TextArea':
                            if (count($bl_altinv) > 0) {
                                $value = $bl_altinv->getValue();
                                $editForm->add('EF-'.$desc,'textarea', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm'),
                                    'label' => $desc, 
                                    'data' => $value, 
                                    'required' => false,
                                ));                                
                            } else {
                                $editForm->add('EF-'.$desc,'textarea', array(
                                    'mapped' => false,
                                    'attr' => array('class' => 'form-control input-sm'),
                                    'label' => $desc, 
                                    'required' => false,
                                ));                                
                            }

                            break;                    
                    }

            }        
        }
        
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($altinv);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Altinv x WHERE x.id = ?1');
            $query->setParameter(1, $altinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'Altinv', 
                            $altinv->getId());
            */
            
            // fin proceso log            
            
            
            // Edito la Bl
            $bl = $em->getRepository('SGIBundle:Bl')
                        ->findOneBy(array('codeBl' => $altinv->getId(),'type' => 'altinv'));
            if (count($bl) > 0) {  
                $description = $altinv->getDescription();
                $bl->setDescription($description);
                $em->persist($bl); 
                $em->flush();     
            }
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_altinv
            $id = $altinv->getId();
            
            $arreglo = $_POST['altinv'];

            // Obtengo unicamente los elementos extra 
            foreach ($arreglo as $key => $value) {
                if (strpos($key, 'EF-') !== 0) {
                    unset($arreglo[$key]);
                } 
            }             
            
            // Procedo a buscar mi campo dentro de la tabla fields
            foreach ($arreglo as $key => $value) {
                $key2 = str_replace("_"," ",$key);
                $key2 = str_replace("EF-","",$key2);
                               
                $field = $em->getRepository('SGIBundle:FieldsAltinv')
                        ->findBy(array('description' => $key2));
                                
                $getid_field = $field[0]->getId();
                
                $bl_altinv = $em->getRepository('SGIBundle:BlAltinv')
                           ->findOneBy(array('idAltinv'=> $id,'idField' => $getid_field));     
                
                // El objeto ya existe
                if (count($bl_altinv) > 0) {     
                    $em->remove($bl_altinv);
                    $em->flush();                   
                }           
                
                $bl_altinv = new BlAltinv();
                
                $id_altinv = $em->getReference
                        ('BL\SGIBundle\Entity\Altinv', $id); 
                

                $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsAltinv', $getid_field); 
                
                if (trim($value) != '') {    
                    $bl_altinv->setIdAltinv($id_altinv);
                    $bl_altinv->setIdField($id_field);
                    $bl_altinv->setValue($value);
                    $em->persist($bl_altinv);
                    $em->flush();       
                }
                
            }            

            
            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['altinv']['name']);
                
                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }
        
                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/altinv/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }        
                
                $arreglo_archivos_name = $arreglo_archivos['altinv']['name'];
                

                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {
                
                    $file_name = $arreglo_archivos['altinv']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {
                    
                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['altinv']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;        
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['altinv']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2); 

                        $field = $em->getRepository('SGIBundle:FieldsAltinv')
                                ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        
                        $bl_altinv = $em->getRepository('SGIBundle:BlAltinv')
                           ->findOneBy(array('idAltinv'=> $id,'idField' => $getid_field));                         
                        $insert = false;
                        // El objeto ya existe
                        if (count($bl_altinv) > 0) {
                            // Si no me llega data no borro el que tengo
                            if (trim($value) != '') {
                                // Si hay un registro nuevo con valor
                                // se borra
                                $ruta_foto_eliminar = $bl_altinv->getValue();
                                $em->remove($bl_altinv);
                                $em->flush();
                                // Borro el archivo fisico
                                unlink($ruta_foto_eliminar);
                                // Creo mi objeto nuevo
                                $bl_altinv = new BlAltinv();
                                $insert = true;
                            }
                        } else {
                            $insert = true;
                        }
                        
                        // Procedo a insertar el archivo en caso de que 
                        // las condiciones sean las deseadas
                        if ($insert) {
                            $bl_altinv = new BlAltinv();

                            $id_altinv = $em->getReference
                                    ('BL\SGIBundle\Entity\Altinv', $id);

                            $id_field = $em->getReference
                                ('BL\SGIBundle\Entity\FieldsAltinv', $getid_field); 

                            if (trim($value) != '') {         
		                $bl_altinv->setIdAltinv($id_altinv);
		                $bl_altinv->setIdField($id_field);
		                $bl_altinv->setValue($destination);
		                $em->persist($bl_altinv);
		                $em->flush();   
                            }                            
                        }

                        $i++;
                    
                    }
                }
            }            
            
            return $this->redirectToRoute('altinv_index');
        }

        return $this->render('altinv/edit.html.twig', array(
            'altinv' => $altinv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Altinv entity.
     *
     * @Route("/{id}", name="altinv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Altinv $altinv)
    {
        $form = $this->createDeleteForm($altinv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Altinv x WHERE x.id = ?1');
            $query->setParameter(1, $altinv->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'Altinv', 
                            $altinv->getId());
            */
            
            // fin proceso log 
            
            $em->remove($altinv);
            $em->flush();
        }

        return $this->redirectToRoute('altinv_index');
    }

    /**
     * Creates a form to delete a Altinv entity.
     *
     * @param Altinv $altinv The Altinv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Altinv $altinv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('altinv_delete', array('id' => $altinv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

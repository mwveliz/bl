<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Comtrad;
use BL\SGIBundle\Form\ComtradType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use BL\SGIBundle\Entity\BlComtrad;
use Symfony\Component\Validator\Constraints\DateTime;
use BL\SGIBundle\Entity\Bl;

/**
 * Comtrad controller.
 *
 * @Route("/comtrad")
 */
class ComtradController extends Controller
{
    /**
     * Lists all Comtrad entities.
     *
     * @Route("/", name="comtrad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comtrads = $em->getRepository('SGIBundle:Comtrad')->findAll();

        $typeComtrads = $em->getRepository('SGIBundle:TypeComtrad')->findAll();
        return $this->render('comtrad/index.html.twig', array(
            'comtrads' => $comtrads, 'typeComtrads' => $typeComtrads
        ));
    }
    
      /**
     * Lists all Comtrad entities by type.
     *
     * @Route("/indexbytype/{type}", name="comtrad_indexbytype")
     * @Method("GET")
     */
    public function indexbytypeAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
        $type=$request->get('type');
        $comtrads = $em->getRepository('SGIBundle:Comtrad')->findByIdTypeComtrad($type);
        $typeComtrads = $em->getRepository('SGIBundle:TypeComtrad')->findById($type);
        return $this->render('comtrad/index.html.twig', array(
            'comtrads' => $comtrads, 'typeComtrads' => $typeComtrads
        ));
    }
    
     /**
     * Lists one  Comtrad dashboard.
     *
     * @Route("/dashboard/{id}", name="comtrad_dashboard")
     * @Method("GET")
     */
    public function dashboardAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $comtrads = $em->getRepository('SGIBundle:Comtrad')->findOneById($id);
        $type=$comtrads->getIdTypeComtrad();
        $typeComtrads = $em->getRepository('SGIBundle:TypeComtrad')->findById($type);
        
        return $this->render('comtrad/index.html.twig', array(
            'comtrads' => $comtrads, 'typeComtrads' => $typeComtrads
        ));
    }
    

    /**
     * Lists all Comtrad entities.
     *
     * @Route("/list", name="comtrad_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comtrads = $em->getRepository('SGIBundle:Comtrad')->findAll();

        return $this->render('comtrad/list.html.twig', array(
            'comtrads' => $comtrads,
        ));
    }
    /**
     * Create Comtrad Type entities.
     *
<<<<<<< HEAD
     * @Route("/add", name="ajax_typecomtrad_create")
=======
     * @Route("/add", name="ajax_typeacomtrad_create")
>>>>>>> cedd939f692c45fd89832bef17130d2238d4bcd6
     * @Method("POST")
     */
    public function ajaxCreateComtrad(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new TypeComtrad();
        $object->setDescription( $request->get('description') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }




    /**
     * Track all Comtrad entities.
     *
     * @Route("/track", name="comtrad_track")
     * @Method("GET")
     */
    public function trackAction()
    {
        $em = $this->getDoctrine()->getManager();


        $fieldsComtradstrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => true));
        $serializer = $this->container->get('serializer');
        $fctracks= $serializer->serialize($fieldsComtradstrackable, 'json');

        $fieldsComtradsnotrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => false));
        $serializer = $this->container->get('serializer');
        $fcnotracks= $serializer->serialize($fieldsComtradsnotrackable, 'json');

        return $this->render('comtrad/track.html.twig', array(
            'fctracks' => $fctracks,'fcnotracks' => $fcnotracks
        ));
    }




    /**
     * Creates a new Comtrad entity.
     *
     * @Route("/new", name="comtrad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $comtrad = new Comtrad();
        $form = $this->createForm('BL\SGIBundle\Form\ComtradType', $comtrad);
              
        $entities = $em->getRepository('SGIBundle:FieldsComtrad')
                    ->findBy(
                        array('trackable'=> false), 
                        array('id' => 'ASC')
                      );
             
        
        foreach ($entities as $entity) {
            
            // Reemplazar los espacios en blanco
            $desc = str_replace(" ","_",$entity->getDescription());            
            
                       
                switch ($entity->getWiget()) {
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
            $em->persist($comtrad);
            $em->flush();
            
            // Procedo log

            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Comtrad x WHERE x.id = ?1');
            $query->setParameter(1, $comtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'Comtrad', 
                            $comtrad->getId());

            
            // fin proceso log             
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_comtrad
            $id = $comtrad->getId();
            
            $arreglo = $_POST['comtrad'];

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
                               
                $field = $em->getRepository('SGIBundle:FieldsComtrad')
                        ->findBy(array('description' => $key2));
                                
                $getid_field = $field[0]->getId();
                
                
                $bl_comtrad = new BlComtrad();
                
                $id_comtrad = $em->getReference
                        ('BL\SGIBundle\Entity\Comtrad', $id); 
                

                $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsComtrad', $getid_field); 
                
                if (trim($value) != '') {    
                    $bl_comtrad->setIdComtrad($id_comtrad);
                    $bl_comtrad->setIdField($id_field);
                    $bl_comtrad->setValue($value);
                    $em->persist($bl_comtrad);
                    $em->flush();       
                }
            }            

            // Inserto la Bl
            $bl= new Bl();
            $bl->setCodeBl($id);
            $bl->setType('comtrad');
            $bl->setDescription($comtrad->getDescription());
            $em->persist($bl); 
            $em->flush();             
            
            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['comtrad']['name']);
                
                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }
        
                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/comtrad/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }        
                
                $arreglo_archivos_name = $arreglo_archivos['comtrad']['name'];
                

                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {
                
                    $file_name = $arreglo_archivos['comtrad']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {
                    
                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['comtrad']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;        
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['comtrad']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2); 

                        $field = $em->getRepository('SGIBundle:FieldsComtrad')
                                ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        $bl_comtrad = new BlComtrad();

                        $id_comtrad = $em->getReference
                                ('BL\SGIBundle\Entity\Comtrad', $id); 


                        $id_field = $em->getReference
                                ('BL\SGIBundle\Entity\FieldsComtrad', $getid_field); 


                        $bl_comtrad->setIdComtrad($id_comtrad);
                        $bl_comtrad->setIdField($id_field);
                        $bl_comtrad->setValue($destination);
                        $em->persist($bl_comtrad);
                        $em->flush();  

                        $i++;
                    
                    }
                }
            }
           
            $comtrads = $em->getRepository('SGIBundle:Comtrad')->findAll();
            $typeComtrads= $em->getRepository('SGIBundle:TypeComtrad')->findAll();
            
            return $this->render('comtrad/index.html.twig', array(
                'comtrads' => $comtrads, 'typeComtrads' => $typeComtrads,
            ));
              
        
        }

        return $this->render('comtrad/new.html.twig', array(
            'comtrad' => $comtrad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Comtrad entity.
     *
     * @Route("/{id}", name="comtrad_show")
     * @Method("GET")
     */
    public function showAction(Comtrad $comtrad)
    {
        $id = $comtrad->getId();  
        $form = 'Comtrad';  
        $table = 'SGIBundle:'.$form;
                
        $em = $this->getDoctrine()->getManager();
        
        $object = $em->getRepository($table)->findOneBy(array('id' => $id));
                       
        $form_lowcase = strtolower($form);
        
        $ruta = $form_lowcase.'/show.html.twig';
        
        switch ($form) {
            case 'Comtrad':
                $nombre_apellido = $object->getIdClient()->getUserid()->getNombre().' ';
                $nombre_apellido .= $object->getIdClient()->getUserid()->getApellido();
                
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
     * Displays a form to edit an existing Comtrad entity.
     *
     * @Route("/{id}/edit", name="comtrad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comtrad $comtrad)
    {
        $deleteForm = $this->createDeleteForm($comtrad);
        $editForm = $this->createForm('BL\SGIBundle\Form\ComtradType', $comtrad);

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SGIBundle:FieldsComtrad')
                    ->findBy(
                        array('trackable'=> false), 
                        array('id' => 'ASC')    
                     );
        if (count($entities) > 0) {
            foreach ($entities as $entity) {
            
                // Reemplazar los espacios en blanco
                $desc = str_replace(" ","_",$entity->getDescription());            

                $bl_comtrad = $em->getRepository('SGIBundle:BlComtrad')
                                ->findOneBy(
                                    array('idField'=> $entity->getId(),'idComtrad' => $comtrad->getId()) 
                                 );       
                        
                
                    switch ($entity->getWiget()) {

                        case 'Calendar':
                            if (count($bl_comtrad) > 0) {
                                $value = $bl_comtrad->getValue();
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
                            if (count($bl_comtrad) > 0) {
                                $value = $bl_comtrad->getValue();
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
                            if (count($bl_comtrad) > 0) {
                                $value = $bl_comtrad->getValue();
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
                            if (count($bl_comtrad) > 0) {
                                $value = $bl_comtrad->getValue(); 
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
                            if (count($bl_comtrad) > 0) {
                                $value = $bl_comtrad->getValue();
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
                            if (count($bl_comtrad) > 0) {
                                $value = $bl_comtrad->getValue();
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
            $em->persist($comtrad);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Comtrad x WHERE x.id = ?1');
            $query->setParameter(1, $comtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'Comtrad', 
                            $comtrad->getId());
            */
            
            // fin proceso log            
            
            
            // Edito la Bl
            $bl = $em->getRepository('SGIBundle:Bl')
                        ->findOneBy(array('codeBl' => $comtrad->getId(),'type' => 'comtrad'));
            if (count($bl) > 0) {  
                $description = $comtrad->getDescription();
                $bl->setDescription($description);
                $em->persist($bl); 
                $em->flush();     
            }
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_comtrad
            $id = $comtrad->getId();
            
            $arreglo = $_POST['comtrad'];

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
                               
                $field = $em->getRepository('SGIBundle:FieldsComtrad')
                        ->findBy(array('description' => $key2));
                                
                $getid_field = $field[0]->getId();
                
                $bl_comtrad = $em->getRepository('SGIBundle:BlComtrad')
                           ->findOneBy(array('idComtrad'=> $id,'idField' => $getid_field));     
                
                // El objeto ya existe
                if (count($bl_comtrad) > 0) {     
                    $em->remove($bl_comtrad);
                    $em->flush();                   
                }           
                
                $bl_comtrad = new BlComtrad();
                
                $id_comtrad = $em->getReference
                        ('BL\SGIBundle\Entity\Comtrad', $id); 
                

                $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsComtrad', $getid_field); 
                
                if (trim($value) != '') {    
                    $bl_comtrad->setIdComtrad($id_comtrad);
                    $bl_comtrad->setIdField($id_field);
                    $bl_comtrad->setValue($value);
                    $em->persist($bl_comtrad);
                    $em->flush();       
                }
                
            }            

            
            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['comtrad']['name']);
                
                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }
        
                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/comtrad/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }        
                
                $arreglo_archivos_name = $arreglo_archivos['comtrad']['name'];
                

                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {
                
                    $file_name = $arreglo_archivos['comtrad']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {
                    
                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['comtrad']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;        
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['comtrad']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2); 

                        $field = $em->getRepository('SGIBundle:FieldsComtrad')
                                ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        
                        $bl_comtrad = $em->getRepository('SGIBundle:BlComtrad')
                           ->findOneBy(array('idComtrad'=> $id,'idField' => $getid_field));                         
                        $insert = false;
                        // El objeto ya existe
                        if (count($bl_comtrad) > 0) {
                            // Si no me llega data no borro el que tengo
                            if (trim($value) != '') {
                                // Si hay un registro nuevo con valor
                                // se borra
                                $ruta_foto_eliminar = $bl_comtrad->getValue();
                                $em->remove($bl_comtrad);
                                $em->flush();
                                // Borro el archivo fisico
                                unlink($ruta_foto_eliminar);
                                // Creo mi objeto nuevo
                                $bl_comtrad = new BlComtrad();
                                $insert = true;
                            }
                        } else {
                            $insert = true;
                        }
                        
                        // Procedo a insertar el archivo en caso de que 
                        // las condiciones sean las deseadas
                        if ($insert) {
                            $bl_comtrad = new BlComtrad();

                            $id_comtrad = $em->getReference
                                    ('BL\SGIBundle\Entity\Comtrad', $id);

                            $id_field = $em->getReference
                                ('BL\SGIBundle\Entity\FieldsComtrad', $getid_field); 

                            if (trim($value) != '') {         
		                $bl_comtrad->setIdComtrad($id_comtrad);
		                $bl_comtrad->setIdField($id_field);
		                $bl_comtrad->setValue($destination);
		                $em->persist($bl_comtrad);
		                $em->flush();   
                            }                            
                        }

                        $i++;
                    
                    }
                }
            }            
            
            return $this->redirectToRoute('comtrad_index');
        }

        return $this->render('comtrad/edit.html.twig', array(
            'comtrad' => $comtrad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comtrad entity.
     *
     * @Route("/delete/{id}", name="comtrad_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $bl_comtrads = $em->getRepository('SGIBundle:BlComtrad')
                    ->findBy(array('idComtrad'=> $id));
        
        if (count($bl_comtrads) > 0) {
            foreach($bl_comtrads as $bl_comtrad) {
                $em->remove($bl_comtrad);
                $em->flush();           
            }
        }
        
        $comtrad = $em->getRepository('SGIBundle:Comtrad')
                    ->findOneBy(array('id'=> $id)); 
        
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Comtrad x WHERE x.id = ?1');
            $query->setParameter(1, $comtrad->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'Comtrad', 
                            $comtrad->getId());
            */
            
            // fin proceso log         
        
        $em->remove($comtrad);
        $em->flush();
        
        return $this->redirectToRoute('comtrad_index');
    }

    /**
     * Creates a form to delete a Comtrad entity.
     *
     * @param Comtrad $comtrad The Comtrad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comtrad $comtrad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comtrad_delete', array('id' => $comtrad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
   
}

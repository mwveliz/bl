<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Constru;
use BL\SGIBundle\Form\ConstruType;
use Doctrine\ORM\Query;
use BL\SGIBundle\Entity\TypeConstru;
use Symfony\Component\HttpFoundation\Response;
use BL\SGIBundle\Entity\BlConstru;
use Symfony\Component\Validator\Constraints\DateTime;
use BL\SGIBundle\Entity\Bl;

/**
 * Constru controller.
 *
 * @Route("/constru")
 */
class ConstruController extends Controller
{
    /**
     * Lists all Constru entities.
     *
     * @Route("/", name="constru_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $construs = $em->getRepository('SGIBundle:Constru')->findAll();
        $typeConstrus = $em->getRepository('SGIBundle:TypeConstru')->findAll();
        return $this->render('constru/index.html.twig', array(
            'construs' => $construs, 'typeConstrus' => $typeConstrus
        ));
    }
    
     /**
     * Lists all Constru entities by type.
     *
     * @Route("/indexbytype/{type}", name="constru_indexbytype")
     * @Method("GET")
     */
    public function indexbytypeAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
        $type=$request->get('type');
        $construs = $em->getRepository('SGIBundle:Constru')->findByIdTypeConstru($type);
        $typeConstrus = $em->getRepository('SGIBundle:TypeConstru')->findById($type);
        return $this->render('constru/index.html.twig', array(
            'construs' => $construs, 'typeConstrus' => $typeConstrus
        ));
    }
    
    
    /**
     * Lists all Constru entities.
     *
     * @Route("/list", name="constru_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $construs = $em->getRepository('SGIBundle:Constru')->findAll();

        return $this->render('constru/list.html.twig', array(
            'construs' => $construs,
        ));
    }

    /**
     * track all Constru entities.
     *
     * @Route("/track", name="constru_track")
     * @Method("GET")
     */
    public function trackAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsConstrustrackable = $em->getRepository('SGIBundle:FieldsConstru')->findBy(array('trackable' => true));
        $serializer = $this->container->get('serializer');
        $fctracks= $serializer->serialize($fieldsConstrustrackable, 'json');

        $fieldsConstrusnotrackable = $em->getRepository('SGIBundle:FieldsConstru')->findBy(array('trackable' => false));
        $serializer = $this->container->get('serializer');
        $fcnotracks= $serializer->serialize($fieldsConstrusnotrackable, 'json');

        return $this->render('constru/track.html.twig', array(
            'fctracks' => $fctracks,'fcnotracks' => $fcnotracks
        ));
    }

    /**
     * Creates a new Constru entity.
     *
     * @Route("/new", name="constru_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $constru = new Constru();
        $form = $this->createForm('BL\SGIBundle\Form\ConstruType', $constru);
         $entities = $em->getRepository('SGIBundle:FieldsConstru')
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
            $em->persist($constru);
            $em->flush();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Constru x WHERE x.id = ?1');
            $query->setParameter(1, $constru->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'Constru', 
                            $constru->getId());
            */
            
            // fin proceso log             
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_constru
            $id = $constru->getId();

            $arreglo = $_POST['constru'];

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

                $field = $em->getRepository('SGIBundle:FieldsConstru')
                    ->findBy(array('description' => $key2));

                $getid_field = $field[0]->getId();


                $bl_constru = new BlConstru();

                $id_constru = $em->getReference
                ('BL\SGIBundle\Entity\Constru', $id);


                $id_field = $em->getReference
                ('BL\SGIBundle\Entity\FieldsConstru', $getid_field);

                if (trim($value) != '') {
                    $bl_constru->setIdConstru($id_constru);
                    $bl_constru->setIdField($id_field);
                    $bl_constru->setValue($value);
                    $em->persist($bl_constru);
                    $em->flush();
                }
            }

            // Inserto la Bl
            $bl= new Bl();
            $bl->setCodeBl($id);
            $bl->setType('constru');
            $bl->setDescription($constru->getDescription());
            $em->persist($bl); 
            $em->flush();  
            
            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['constru']['name']);

                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }

                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/constru/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }

                $arreglo_archivos_name = $arreglo_archivos['constru']['name'];


                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {

                    $file_name = $arreglo_archivos['constru']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {

                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['constru']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['constru']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2);

                        $field = $em->getRepository('SGIBundle:FieldsConstru')
                            ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        $bl_constru = new BlConstru();

                        $id_constru = $em->getReference
                        ('BL\SGIBundle\Entity\Constru', $id);


                        $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsConstru', $getid_field);


                        $bl_constru->setIdConstru($id_constru);
                        $bl_constru->setIdField($id_field);
                        $bl_constru->setValue($destination);
                        $em->persist($bl_constru);
                        $em->flush();

                        $i++;

                    }
                }
            }

            $construs = $em->getRepository('SGIBundle:Constru')->findAll();
             $typeConstrus = $em->getRepository('SGIBundle:TypeConstru')->findAll();
             
            return $this->render('constru/index.html.twig', array(
                'construs' => $construs, 'typeConstrus' => $typeConstrus,
            ));
        }
        return $this->render('constru/new.html.twig', array(
            'constru' => $constru,
            'form' => $form->createView(),
        ));
    }

    /**
     * Create Constru Type entities.
     *
     * @Route("/add", name="ajax_typeconstru_create")
     * @Method("POST")
     */

    public function ajaxCreateTypeConstru(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $object= new TypeConstru();
        $object->setDescription( $request->get('description') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }



    /**
     * Finds and displays a Constru entity.
     *
     * @Route("/{id}", name="constru_show")
     * @Method("GET")
     */
    public function showAction(Constru $constru)
    {
        $deleteForm = $this->createDeleteForm($constru);

        return $this->render('constru/show.html.twig', array(
            'constru' => $constru,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Constru entity.
     *
     * @Route("/{id}/edit", name="constru_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Constru $constru)
    {
        $deleteForm = $this->createDeleteForm($constru);
        $editForm = $this->createForm('BL\SGIBundle\Form\ConstruType', $constru);

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SGIBundle:FieldsConstru')
                    ->findBy(
                        array('trackable'=> false), 
                        array('id' => 'ASC')    
                     );
        if (count($entities) > 0) {
            foreach ($entities as $entity) {
            
                // Reemplazar los espacios en blanco
                $desc = str_replace(" ","_",$entity->getDescription());            

                $bl_constru = $em->getRepository('SGIBundle:BlConstru')
                                ->findOneBy(
                                    array('idField'=> $entity->getId(),'idConstru' => $constru->getId()) 
                                 );       
                        
                
                    switch ($entity->getWidget()) {

                        case 'Calendar':
                            if (count($bl_constru) > 0) {
                                $value = $bl_constru->getValue();
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
                            if (count($bl_constru) > 0) {
                                $value = $bl_constru->getValue();
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
                            if (count($bl_constru) > 0) {
                                $value = $bl_constru->getValue();
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
                            if (count($bl_constru) > 0) {
                                $value = $bl_constru->getValue(); 
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
                            if (count($bl_constru) > 0) {
                                $value = $bl_constru->getValue();
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
                            if (count($bl_constru) > 0) {
                                $value = $bl_constru->getValue();
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
            $em->persist($constru);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Constru x WHERE x.id = ?1');
            $query->setParameter(1, $constru->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'Constru', 
                            $constru->getId());
            */
            
            // fin proceso log            
            
            
            // Edito la Bl
            $bl = $em->getRepository('SGIBundle:Bl')
                        ->findOneBy(array('codeBl' => $constru->getId(),'type' => 'constru'));
            if (count($bl) > 0) {  
                $description = $constru->getDescription();
                $bl->setDescription($description);
                $em->persist($bl); 
                $em->flush();     
            }
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_constru
            $id = $constru->getId();
            
            $arreglo = $_POST['constru'];

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
                               
                $field = $em->getRepository('SGIBundle:FieldsConstru')
                        ->findBy(array('description' => $key2));
                                
                $getid_field = $field[0]->getId();
                
                $bl_constru = $em->getRepository('SGIBundle:BlConstru')
                           ->findOneBy(array('idConstru'=> $id,'idField' => $getid_field));     
                
                // El objeto ya existe
                if (count($bl_constru) > 0) {     
                    $em->remove($bl_constru);
                    $em->flush();                   
                }           
                
                $bl_constru = new BlConstru();
                
                $id_constru = $em->getReference
                        ('BL\SGIBundle\Entity\Constru', $id); 
                

                $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsConstru', $getid_field); 
                
                if (trim($value) != '') {    
                    $bl_constru->setIdConstru($id_constru);
                    $bl_constru->setIdField($id_field);
                    $bl_constru->setValue($value);
                    $em->persist($bl_constru);
                    $em->flush();       
                }
                
            }            

            
            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['constru']['name']);
                
                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }
        
                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/constru/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }        
                
                $arreglo_archivos_name = $arreglo_archivos['constru']['name'];
                

                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {
                
                    $file_name = $arreglo_archivos['constru']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {
                    
                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['constru']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;        
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['constru']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2); 

                        $field = $em->getRepository('SGIBundle:FieldsConstru')
                                ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        
                        $bl_constru = $em->getRepository('SGIBundle:BlConstru')
                           ->findOneBy(array('idConstru'=> $id,'idField' => $getid_field));                         
                        $insert = false;
                        // El objeto ya existe
                        if (count($bl_constru) > 0) {
                            // Si no me llega data no borro el que tengo
                            if (trim($value) != '') {
                                // Si hay un registro nuevo con valor
                                // se borra
                                $ruta_foto_eliminar = $bl_constru->getValue();
                                $em->remove($bl_constru);
                                $em->flush();
                                // Borro el archivo fisico
                                unlink($ruta_foto_eliminar);
                                // Creo mi objeto nuevo
                                $bl_constru = new BlConstru();
                                $insert = true;
                            }
                        } else {
                            $insert = true;
                        }
                        
                        // Procedo a insertar el archivo en caso de que 
                        // las condiciones sean las deseadas
                        if ($insert) {
                            $bl_constru = new BlConstru();

                            $id_constru = $em->getReference
                                    ('BL\SGIBundle\Entity\Constru', $id);

                            $id_field = $em->getReference
                                ('BL\SGIBundle\Entity\FieldsConstru', $getid_field); 

                            if (trim($value) != '') {         
		                $bl_constru->setIdConstru($id_constru);
		                $bl_constru->setIdField($id_field);
		                $bl_constru->setValue($destination);
		                $em->persist($bl_constru);
		                $em->flush();   
                            }                            
                        }

                        $i++;
                    
                    }
                }
            }            
            
            return $this->redirectToRoute('constru_index');
        }

        return $this->render('constru/edit.html.twig', array(
            'constru' => $constru,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Constru entity.
     *
     * @Route("/{id}", name="constru_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Constru $constru)
    {
        $form = $this->createDeleteForm($constru);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Constru x WHERE x.id = ?1');
            $query->setParameter(1, $constru->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'Constru', 
                            $constru->getId());
            */
            
            // fin proceso log 
            
            $em->remove($constru);
            $em->flush();
        }

        return $this->redirectToRoute('constru_index');
    }

    /**
     * Creates a form to delete a Constru entity.
     *
     * @param Constru $constru The Constru entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Constru $constru)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('constru_delete', array('id' => $constru->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

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

        return $this->render('comtrad/index.html.twig', array(
            'comtrads' => $comtrads,
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
        
        $clients = $em->getRepository('SGIBundle:Client')->findAll();

        $clientes = array();
        foreach ($clients as $client) {
            $clientes = $client->getUserid();
        }
        
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
                        $form->add('EF-'.$desc, 'date', [
                            'widget' => 'single_text',
                            'format' => 'dd-MM-yyyy',
                            'attr' => [
                                'class' => 'form-control datepicker',
                                'data-provide' => 'datepicker',
                                'data-date-format' => 'dd-mm-yyyy'
                            ],
                            'mapped' => false,
                            'label' => $desc, 
                        ]);                        
                        break;
                    case 'Characters':
                        $form->add('EF-'.$desc,'text', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm'),
                            'label' => $desc, 
                        ));
                        break;
                    case 'Currency':
                        $form->add('EF-'.$desc,'number', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm currency'),
                            'label' => $desc, 
                        ));
                        break;
                    case 'File':
                        $form->add('EF-'.$desc,'file', array(
                            'mapped' => false,
                            'label' => $desc, 
                        ));
                        break; 
                    case 'Numeric':
                        $form->add('EF-'.$desc,'number', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm numeric'),
                            'label' => $desc, 
                        ));
                        break;
                    case 'TextArea':
                        $form->add('EF-'.$desc,'textarea', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm'),
                            'label' => $desc, 
                        ));
                        break;                    
                }
                  
        }
               
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comtrad);
            $em->flush();
            
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
                
                    
                $bl_comtrad->setIdComtrad($id_comtrad);
                $bl_comtrad->setIdField($id_field);
                $bl_comtrad->setValue($value);
                $em->persist($bl_comtrad);
                $em->flush();                
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
                
                foreach ($arreglo_archivos_name as $key => $value) {
                
                    $file_name = $arreglo_archivos['comtrad']['name'][$key];
                    $time=  time();
                    
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
    
                }
            }
           
            $comtrads = $em->getRepository('SGIBundle:Comtrad')->findAll();

            return $this->render('comtrad/index.html.twig', array(
                'comtrads' => $comtrads,
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
        $deleteForm = $this->createDeleteForm($comtrad);

        return $this->render('comtrad/show.html.twig', array(
            'comtrad' => $comtrad,
            'delete_form' => $deleteForm->createView(),
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
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comtrad);
            $em->flush();
            
            $comtrads = $em->getRepository('SGIBundle:Comtrad')->findAll();

            return $this->render('comtrad/index.html.twig', array(
                'comtrads' => $comtrads,
            ));
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
     * @Route("/{id}", name="comtrad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comtrad $comtrad)
    {
        $form = $this->createDeleteForm($comtrad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comtrad);
            $em->flush();
        }

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

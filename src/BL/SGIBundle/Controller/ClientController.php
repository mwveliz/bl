<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Client;
use BL\SGIBundle\Form\ClientType;
use BL\SGIBundle\Entity\BlClient;
/**
 * Client controller.
 *
 * @Route("/client")
 */
class ClientController extends Controller
{
    /**
     * Lists all Client entities.
     *
     * @Route("/", name="client_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('SGIBundle:Client')->findAll();

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }
  /**
     * Lists all Client entities.
     *
     * @Route("/", name="client_index_ajax")
     * @Method("POST")
     */
    public function ajaxindexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('SGIBundle:Client')->findAll();
        $objeto=array();
        $arreglo=array();

        foreach($clients  as $client){
            $indice=(string) $client->getId();
            $objeto['id']=(string) $client->getId();
            $objeto['value']= $client->getName().' '. $client->getLastname();
            array_push($arreglo, $objeto);
        }

        return new JsonResponse($arreglo);
    }
    
    /**
     * Create Usuario entities via client ajax.
     *
     * @Route("/add", name="ajax_client_create")
     * @Method("POST")
     */
    public function ajaxCreateClient(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client= new Client();
        $client->setName($_POST['client']['name']);
        $client->setLastname($_POST['client']['lastname']);
        $client->setTreatment($_POST['client']['treatment']);
        $client->setAddress($_POST['client']['address']);
        $client->setContact($_POST['client']['contact']);
        $client->setEmailOne($_POST['client']['emailOne']);
        $client->setEmailTwo($_POST['client']['emailTwo']);
        $client->setLegalId($_POST['client']['legalId']);
        //$client->setPicture($_POST['client']['picture]');
        //$client->setLogo($_POST['client']['logo]');
        
        
        $em->persist($client);
        $em->flush();
        

        $id_client=$client->getId();
        
        
        $arreglo = $_POST['client'];
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

                $field = $em->getRepository('SGIBundle:FieldsClient')
                    ->findBy(array('description' => $key2));

                $getid_field = $field[0]->getId();


                $bl_client = new BlClient();

                $id = $em->getReference
                ('BL\SGIBundle\Entity\Client', $id_client);


                $id_field = $em->getReference
                ('BL\SGIBundle\Entity\FieldsClient', $getid_field);

                if (trim($value) != '') {
                    $bl_client->setIdClient($id);
                    $bl_client->setIdField($id_field);
                    $bl_client->setValue($value);
                    $em->persist($bl_client);
                    $em->flush();
                }
            }


            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['client']['name']);

                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }

                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/client/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }

                $arreglo_archivos_name = $arreglo_archivos['client']['name'];


                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {

                    $file_name = $arreglo_archivos['client']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {

                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['client']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['client']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2);

                        $field = $em->getRepository('SGIBundle:FieldsClient')
                            ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        $bl_client = new BlClient();

                        $id = $em->getReference
                        ('BL\SGIBundle\Entity\Client', $id_client);


                        $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsClient', $getid_field);


                        $bl_client->setIdClient($id);
                        $bl_client->setIdField($id_field);
                        $bl_client->setValue($destination);
                        $em->persist($bl_client);
                        $em->flush();

                        $i++;

                    }
                }
            }
        return new Response($id_client);
        
    }

    /**
     * Creates a new Client entity.
     *
     * @Route("/new", name="client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        
        
        $em = $this->getDoctrine()->getManager();
        $client= new Client();
        $ruta='client/new.html.twig';
        $client = new Client();
        $fieldsclient =new \BL\SGIBundle\Entity\FieldsClient;
        $form = $this->createForm('BL\SGIBundle\Form\ClientType', $client);
        $fieldsform = $this->createForm('BL\SGIBundle\Form\FieldsClientType', $fieldsclient);
        
        $entities = $em->getRepository('SGIBundle:FieldsClient')
            ->findBy(
                array('visible'=> true),
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
                    $form->add('EF-'.$desc,'number', array(
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
        }//fin foreach entities extrafields
        
        
        $form->handleRequest($request);

        
        
        
        if ($form->isSubmitted() && $form->isValid()) {
             
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            
            
             $arreglo = $_POST["EF"];
             

              return $this->redirectToRoute('client_index');
        }
         if ($request->isXmlHttpRequest()) $ruta='client/ajax_new.html.twig';

         
         
        return $this->render($ruta, array(
            'client' => $client,
            'form' => $form->createView(),
            'fieldsform' => $fieldsform->createView(),
        ));
    }

    
    /**
     * Show client in the right side via ajax.
     *
     * @Route("/ajaxshow", name="client_ajaxshow")
     * @Method("GET")
     */
    public function showaccountsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $client = $em->getRepository('SGIBundle:Client')->findOneById($id); 
        
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/ajax_show.html.twig', array(
            'delete_form' => $deleteForm->createView(),
            'client' => $client
        ));
    }
    /**
     * Finds and displays a Client entity.
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('BL\SGIBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

             return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Client entity.
     *
     * @Route("/{id}", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Client $client)
    {
        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a Client entity.
     *
     * @param Client $client The Client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

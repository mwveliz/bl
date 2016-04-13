<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Rental;
use BL\SGIBundle\Entity\TypeRental;
use BL\SGIBundle\Form\RentalType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use BL\SGIBundle\Entity\BlComtrad;
use Symfony\Component\Validator\Constraints\DateTime;
use BL\SGIBundle\Entity\Bl;

/**
 * Rental controller.
 *
 * @Route("/rental")
 */
class RentalController extends Controller
{
    /**
     * Lists all Rental entities.
     *
     * @Route("/", name="rental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rentals = $em->getRepository('SGIBundle:Rental')->findAll();
        $typeRentals = $em->getRepository('SGIBundle:TypeRental')->findAll();
        return $this->render('rental/index.html.twig', array(
            'rentals' => $rentals, 'typeRentals' => $typeRentals
        ));
    }

    /**
     * Lists all Rental entities.
     *
     * @Route("/list", name="rental_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rentals = $em->getRepository('SGIBundle:Rental')->findAll();

        return $this->render('rental/list.html.twig', array(
            'rentals' => $rentals,
        ));
    }


    /**
     * Lists all Rental entities.
     *
     * @Route("/track", name="rental_track")
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

        return $this->render('rental/track.html.twig', array(
            'fctracks' => $fctracks,'fcnotracks' => $fcnotracks
        ));
    }

    /**
     * Creates a new Rental entity.
     *
     * @Route("/new", name="rental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
                $em = $this->getDoctrine()->getManager();

        $rental = new Rental();
        $form = $this->createForm('BL\SGIBundle\Form\RentalType', $rental);
        
        $entities = $em->getRepository('SGIBundle:FieldsRental')
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

        }


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rental);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Rental x WHERE x.id = ?1');
            $query->setParameter(1, $rental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'Rental', 
                            $rental->getId());
            */
            
            // fin proceso log             
            
            // Obtengo mi id y procedo a realizar los inserts en la tabla
            // bl_rental
            $id = $rental->getId();

            $arreglo = $_POST['rental'];

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

                $field = $em->getRepository('SGIBundle:FieldsRental')
                    ->findBy(array('description' => $key2));

                $getid_field = $field[0]->getId();


                $bl_rental = new BlRental();

                $id_rental = $em->getReference
                ('BL\SGIBundle\Entity\Rental', $id);


                $id_field = $em->getReference
                ('BL\SGIBundle\Entity\FieldsRental', $getid_field);

                if (trim($value) != '') {
                    $bl_rental->setIdRental($id_rental);
                    $bl_rental->setIdField($id_field);
                    $bl_rental->setValue($value);
                    $em->persist($bl_rental);
                    $em->flush();
                }
            }


            // Procedo a insertar cada uno de mis tipo Archivo
            $arreglo_archivos = $_FILES;
            if (count($arreglo_archivos) > 0) {
                $n = count($arreglo_archivos['rental']['name']);

                // Crear un directorio dentro de Web
                if (!file_exists('photos')) {
                    mkdir('photos', 0777, true);
                }

                // Creo un directorio dentro que identifica a mi Controlador
                $ruta_foto = 'photos/rental/';
                if (!file_exists($ruta_foto)) {
                    mkdir($ruta_foto, 0777, true);
                }

                $arreglo_archivos_name = $arreglo_archivos['rental']['name'];


                $i = 0;
                foreach ($arreglo_archivos_name as $key => $value) {

                    $file_name = $arreglo_archivos['rental']['name'][$key].' ';
                    $time=  time().''.$i;
                    if (trim($file_name) != '') {

                        // Obtengo la extensión de la imagen y la concateno
                        list($img,$type) = explode('/', $arreglo_archivos['rental']['type'][$key]);
                        $new_image_name =  $time.'.'.$type;
                        $destination = $ruta_foto.$new_image_name;

                        // Realiza el movimiento de la foto
                        move_uploaded_file($arreglo_archivos['rental']['tmp_name'][$key], $destination);

                        // Creo mi registro
                        $key2 = str_replace("_"," ",$key);
                        $key2 = str_replace("EF-","",$key2);

                        $field = $em->getRepository('SGIBundle:FieldsRental')
                            ->findBy(array('description' => $key2));

                        $getid_field = $field[0]->getId();

                        $bl_rental = new BlRental();

                        $id_rental = $em->getReference
                        ('BL\SGIBundle\Entity\Rental', $id);


                        $id_field = $em->getReference
                        ('BL\SGIBundle\Entity\FieldsRental', $getid_field);


                        $bl_rental->setIdRental($id_rental);
                        $bl_rental->setIdField($id_field);
                        $bl_rental->setValue($destination);
                        $em->persist($bl_rental);
                        $em->flush();

                        $i++;

                    }
                }
            }
           $rentals = $em->getRepository('SGIBundle:Rental')->findAll();

            return $this->render('rental/index.html.twig', array(
                'rentals' => $rentals,
            ));
        }

        return $this->render('rental/new.html.twig', array(
            'rental' => $rental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Create Rental Type entities.
     *
     * @Route("/add", name="ajax_typerental_create")
     * @Method("POST")
     */
    public function ajaxCreateRental(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new TypeRental();
        $object->setDescription( $request->get('description') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }


    /**
     * Finds and displays a Rental entity.
     *
     * @Route("/{id}", name="rental_show")
     * @Method("GET")
     */
    public function showAction(Rental $rental)
    {
        $deleteForm = $this->createDeleteForm($rental);

        return $this->render('rental/show.html.twig', array(
            'rental' => $rental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Rental entity.
     *
     * @Route("/{id}/edit", name="rental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rental $rental)
    {
        $deleteForm = $this->createDeleteForm($rental);
        $editForm = $this->createForm('BL\SGIBundle\Form\RentalType', $rental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rental);
            $em->flush();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Rental x WHERE x.id = ?1');
            $query->setParameter(1, $rental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'Rental', 
                            $rental->getId());
            */
            
            // fin proceso log              
            
            return $this->redirectToRoute('rental_edit', array('id' => $rental->getId()));
        }

        return $this->render('rental/edit.html.twig', array(
            'rental' => $rental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Rental entity.
     *
     * @Route("/{id}", name="rental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rental $rental)
    {
        $form = $this->createDeleteForm($rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:Rental x WHERE x.id = ?1');
            $query->setParameter(1, $rental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'Rental', 
                            $rental->getId());
            */
            
            // fin proceso log
            
            $em->remove($rental);
            $em->flush();
        }

        return $this->redirectToRoute('rental_index');
    }

    /**
     * Creates a form to delete a Rental entity.
     *
     * @param Rental $rental The Rental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rental $rental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rental_delete', array('id' => $rental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

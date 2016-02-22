<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Altinv;
use BL\SGIBundle\Form\AltinvType;

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

        return $this->render('altinv/index.html.twig', array(
            'altinvs' => $altinvs,
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
     * Tracks all Altinv entities.
     *
     * @Route("/track", name="altinv_track")
     * @Method("GET")
     */
    public function trackAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsAltinvstrackable = $em->getRepository('SGIBundle:FieldsAltinv')->findBy(array('trackable' => true));
        $serializer = $this->container->get('serializer');
        $aitracks= $serializer->serialize($fieldsAltinvstrackable, 'json');

        $fieldsAltinvsnotrackable = $em->getRepository('SGIBundle:FieldsAltinv')->findBy(array('trackable' => false));
        $serializer = $this->container->get('serializer');
        $ainotracks= $serializer->serialize($fieldsAltinvsnotrackable, 'json');

        return $this->render('altinv/track.html.twig', array(
            'aitracks' => $aitracks,'ainotracks' => $ainotracks
        ));
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
            $em->persist($altinv);
            $em->flush();

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

            return $this->render('altinv/index.html.twig', array(
                'altinvs' => $altinvs,
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
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($altinv);
            $em->flush();

            return $this->redirectToRoute('altinv_edit', array('id' => $altinv->getId()));
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

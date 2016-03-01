<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Rental;
use BL\SGIBundle\Form\RentalType;

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

        return $this->render('rental/index.html.twig', array(
            'rentals' => $rentals,
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
        $rental = new Rental();
        $form = $this->createForm('BL\SGIBundle\Form\RentalType', $rental);
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
            
            return $this->redirectToRoute('rental_show', array('id' => $rental->getId()));
        }

        return $this->render('rental/new.html.twig', array(
            'rental' => $rental,
            'form' => $form->createView(),
        ));
    }

    /**
     * Create Rental Type entities.
     *
     * @Route("/add", name="ajax_typearental_create")
     * @Method("POST")
     */
    public function ajaxCreateRental(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new TypeComtrad();
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

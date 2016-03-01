<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\TypeRental;
use BL\SGIBundle\Form\TypeRentalType;

/**
 * TypeRental controller.
 *
 * @Route("/typerental")
 */
class TypeRentalController extends Controller
{
    /**
     * Lists all TypeRental entities.
     *
     * @Route("/", name="typerental_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeRentals = $em->getRepository('SGIBundle:TypeRental')->findAll();

        return $this->render('typerental/index.html.twig', array(
            'typeRentals' => $typeRentals,
        ));
    }

    /**
     * Creates a new TypeRental entity.
     *
     * @Route("/new", name="typerental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $ruta ='typerental/new.html.twig';

        $typeRental = new TypeRental();
        $form = $this->createForm('BL\SGIBundle\Form\TypeRentalType', $typeRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeRental);
            $em->flush();


            return $this->redirectToRoute('typerental_show', array('id' => $typeRental->getId()));
        }
        if ($request->isXmlHttpRequest()) $ruta='typerental/ajax_new.html.twig';

      return $this->render($ruta, array(
            'typeRental' => $typeRental,
            'form' => $form->createView(),
        ));

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeRental x WHERE x.id = ?1');
            $query->setParameter(1, $typeRental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Insert', 'TypeRental', 
                            $typeRental->getId());
            */            
       

    }


    /**
     * Create Comtrad Type entities.
     *
     * @Route("/add", name="ajax_typerental_create")
     * @Method("POST")
     */
    public function ajaxCreateTypeRental(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $object= new TypeRental();
        $object->setDescription( $request->get('description') );
        $em->persist($object);
        $em->flush();

        return new JsonResponse($object->getId());
    }


    /**
     * Finds and displays a TypeRental entity.
     *
     * @Route("/{id}", name="typerental_show")
     * @Method("GET")
     */
    public function showAction(TypeRental $typeRental)
    {
        $deleteForm = $this->createDeleteForm($typeRental);

        return $this->render('typerental/show.html.twig', array(
            'typeRental' => $typeRental,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeRental entity.
     *
     * @Route("/{id}/edit", name="typerental_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeRental $typeRental)
    {
        $deleteForm = $this->createDeleteForm($typeRental);
        $editForm = $this->createForm('BL\SGIBundle\Form\TypeRentalType', $typeRental);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeRental);
            $em->flush();


            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeRental x WHERE x.id = ?1');
            $query->setParameter(1, $typeRental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Update', 'TypeRental', 
                            $typeRental->getId());
            */
            
            // fin proceso log 
            
            return $this->redirectToRoute('typerental_edit', array('id' => $typeRental->getId()));
        }

        return $this->render('typerental/edit.html.twig', array(
            'typeRental' => $typeRental,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeRental entity.
     *
     * @Route("/{id}", name="typerental_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeRental $typeRental)
    {
        $form = $this->createDeleteForm($typeRental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Procedo log
            /*
            $userManager = $this->container->get('fos_user.user_manager');

            $user = $userManager->findUserByUsername($this->container->get('security.context')
                            ->getToken()
                            ->getUser());
            

            $query = $em->createQuery('SELECT x FROM SGIBundle:TypeRental x WHERE x.id = ?1');
            $query->setParameter(1, $typeRental->getId());
            $arreglo_formulario = $query->getSingleResult(Query::HYDRATE_ARRAY);

            $bitacora = $em->getRepository('SGIBundle:LogActivity')
                    ->bitacora($user->getId(), 'Delete', 'TypeRental', 
                            $typeRental->getId());
            */
            
            // fin proceso log 
            

            $em->remove($typeRental);
            $em->flush();
        }

        return $this->redirectToRoute('typerental_index');
    }

    /**
     * Creates a form to delete a TypeRental entity.
     *
     * @param TypeRental $typeRental The TypeRental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeRental $typeRental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typerental_delete', array('id' => $typeRental->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

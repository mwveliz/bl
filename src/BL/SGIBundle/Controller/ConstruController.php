<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Constru;
use BL\SGIBundle\Form\ConstruType;
use BL\SGIBundle\Entity\TypeConstru;

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

        $fieldsComtradstrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => true));
        $serializer = $this->container->get('serializer');
        $fctracks= $serializer->serialize($fieldsComtradstrackable, 'json');

        $fieldsComtradsnotrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => false));
        $serializer = $this->container->get('serializer');
        $fcnotracks= $serializer->serialize($fieldsComtradsnotrackable, 'json');

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
            
            
            return $this->redirectToRoute('constru_show', array('id' => $constru->getId()));
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
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
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
            
            return $this->redirectToRoute('constru_edit', array('id' => $constru->getId()));
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

<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\State;
use BL\SGIBundle\Form\StateType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * State controller.
 *
 * @Route("/state")
 */
class StateController extends Controller
{
    /**
     * Lists all State entities.
     *
     * @Route("/", name="state_index")
      * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SGIBundle:State');
	$busqueda=$request->get('query') .'%';
	$states = $repository->createQueryBuilder('o')->where('o.description LIKE :q')->setParameter('q', $busqueda)->getQuery()->getResult();

     /*   $states = $em->getRepository('SGIBundle:State')
        			->where('description LIKE '. $busqueda)
  				->execute();
       */ 
        $objeto=array();
        $arreglo=array();

        foreach($states  as $state){
            $indice=(string) $state->getId();
            $objeto['id']=(string) $state->getId();
            $objeto['value']= $state->getIdCountry()->getDescription() . ' - ' .$state->getDescription();
            array_push($arreglo, $objeto);
        }

        return new JsonResponse($arreglo);
    }    

    /**
     * Lists all States entities.
     *
     * @Route("/ajax_index", name="state_index_ajax")
     * @Method({"GET", "POST"})
     */
    public function ajaxindexAction(Request $request)
     {
       $repository = $this->getDoctrine()->getRepository('SGIBundle:State');
	$busqueda=$request->get('query') .'%';
	$states = $repository->createQueryBuilder('o')->where('o.description LIKE :q')->setParameter('q', $busqueda)->getQuery()->getResult();

     /*   $states = $em->getRepository('SGIBundle:State')
        			->where('description LIKE '. $busqueda)
  				->execute();
       */ 
        $objeto=array();
        $arreglo=array();

        foreach($states  as $state){
            $indice=(string) $state->getId();
            $objeto['id']=(string) $state->getId();
            $objeto['value']= $state->getIdCountry()->getDescription() . ' - ' .$state->getDescription();
            array_push($arreglo, $objeto);
        }

        return new JsonResponse($arreglo);
    }      
    
    /**
     * Creates a new State entity.
     *
     * @Route("/new", name="state_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $state = new State();
        $form = $this->createForm('BL\SGIBundle\Form\StateType', $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($state);
            $em->flush();

            return $this->redirectToRoute('state_show', array('id' => $state->getId()));
        }

        return $this->render('state/new.html.twig', array(
            'state' => $state,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a State entity.
     *
     * @Route("/{id}", name="state_show")
     * @Method("GET")
     */
    public function showAction(State $state)
    {
        $deleteForm = $this->createDeleteForm($state);

        return $this->render('state/show.html.twig', array(
            'state' => $state,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing State entity.
     *
     * @Route("/{id}/edit", name="state_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, State $state)
    {
        $deleteForm = $this->createDeleteForm($state);
        $editForm = $this->createForm('BL\SGIBundle\Form\StateType', $state);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($state);
            $em->flush();

            return $this->redirectToRoute('state_edit', array('id' => $state->getId()));
        }

        return $this->render('state/edit.html.twig', array(
            'state' => $state,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a State entity.
     *
     * @Route("/{id}", name="state_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, State $state)
    {
        $form = $this->createDeleteForm($state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($state);
            $em->flush();
        }

        return $this->redirectToRoute('state_index');
    }

    /**
     * Creates a form to delete a State entity.
     *
     * @param State $state The State entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(State $state)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('state_delete', array('id' => $state->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

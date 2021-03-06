<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Client;
use BL\SGIBundle\Form\ClientType;
use BL\SGIBundle\Entity\Usuario;
use BL\SGIBundle\Form\UsuarioType;


use Symfony\Component\HttpFoundation\JsonResponse;

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
            $objeto['value']= $client->getUserid()->getNombre().' '. $client->getUserid()->getApellido();
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
        $object= new Usuario();
        $object->setPassword(123456);
        $object->setEnabled(true);
        $form = $this->createForm('BL\SGIBundle\Form\UsuarioType', $object);
        $form->bind($request);
        if ($form->isValid()){
            $em->persist($object);
            $em->flush();
        }
        
        return new Response($object->getId());
        
    }


    /**
     * Creates a new Client entity.
     *
     * @Route("/new", name="client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ruta='client/new.html.twig';
        $client = new Usuario();
        $form = $this->createForm('BL\SGIBundle\Form\UsuarioType', $client);
        // $form ->setAction($this->generateUrl('client/ajax_create'))
       // $client = new Client();
       //$form = $this->createForm('BL\SGIBundle\Form\ClientType', $client);
       $form->remove('plainPassword');
       $form->remove('enabled');
       
       
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_index');
        }

        
        
          if ($request->isXmlHttpRequest()) $ruta='client/ajax_new.html.twig';

          
          
        return $this->render($ruta, array(
            'client' => $client,
            'form' => $form->createView(),
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

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
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
    
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user_index_ajax")
     * @Method("POST")
     */
    public function ajaxuserindexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('SGIBundle:Client')->findBy(array('enabled' => true));
        $objeto=array();
        $arreglo=array();

        foreach($users  as $user){
            $indice=(string) $user->getId();
            $objeto['id']=(string) $user->getId();
            $objeto['value']= $user->getNombre().' '. $user->getApellido();
            array_push($arreglo, $objeto);
        }

        return new JsonResponse($arreglo);
    }    
}

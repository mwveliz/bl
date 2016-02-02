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
        
      //  die(var_dump($clientes));

        $entities = $em->getRepository('SGIBundle:FieldsComtrad')
                ->findByTrackable(false);
             
        
        foreach ($entities as $entity) {
            
                switch ($entity->getWiget()) {
                    case 'Calendar':
                        $form->add($entity->getDescription(),'date', array(
                            'input'  => 'timestamp',
                            'widget' => 'choice',
                            'mapped' => false,
                        ));
                        break;
                    case 'Characters':
                        $form->add($entity->getDescription(),'text', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm')
                        ));
                        break;
                    case 'Currency':
                        $form->add($entity->getDescription(),'number', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm')
                        ));
                        break;
                    case 'File':
                        $form->add($entity->getDescription(),'file', array(
                            'mapped' => false,
                        ));
                        break; 
                    case 'Numeric':
                        $form->add($entity->getDescription(),'number', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm')
                        ));
                        break;
                    case 'TextArea':
                        $form->add($entity->getDescription(),'textarea', array(
                            'mapped' => false,
                            'attr' => array('class' => 'form-control input-sm')
                        ));
                        break;                    
                }
                  
        }
               
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comtrad);
            $em->flush();
            
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

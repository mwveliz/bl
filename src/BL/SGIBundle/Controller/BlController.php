<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\Bl;
use BL\SGIBundle\Form\BlType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Bl controller.
 *
 * @Route("/bl")
 */
class BlController extends Controller
{
    /**
     * Lists all Bl entities.
     *
     * @Route("/", name="bl_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bls = $em->getRepository('SGIBundle:Bl')->findAll();

        return $this->render('bl/index.html.twig', array(
            'bls' => $bls,
        ));
    }

    /**
     * Creates a new Bl entity.
     *
     * @Route("/new", name="bl_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bl = new Bl();
        $form = $this->createForm('BL\SGIBundle\Form\BlType', $bl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();

            return $this->redirectToRoute('bl_show', array('id' => $bl->getId()));
        }

        return $this->render('bl/new.html.twig', array(
            'bl' => $bl,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bl entity.
     *
     * @Route("/{id}", name="bl_show")
     * @Method("GET")
     */
    public function showAction(Bl $bl)
    {
        $deleteForm = $this->createDeleteForm($bl);

        return $this->render('bl/show.html.twig', array(
            'bl' => $bl,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Bl entity.
     *
     * @Route("/{id}/edit", name="bl_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bl $bl)
    {
        $deleteForm = $this->createDeleteForm($bl);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlType', $bl);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bl);
            $em->flush();

            return $this->redirectToRoute('bl_edit', array('id' => $bl->getId()));
        }

        return $this->render('bl/edit.html.twig', array(
            'bl' => $bl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bl entity.
     *
     * @Route("/{id}", name="bl_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bl $bl)
    {
        $form = $this->createDeleteForm($bl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bl);
            $em->flush();
        }

        return $this->redirectToRoute('bl_index');
    }

    /**
     * Creates a form to delete a Bl entity.
     *
     * @param Bl $bl The Bl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bl $bl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bl_delete', array('id' => $bl->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * @Route("/ajax/mostrar", name="show_ajax")
     * @Method("GET")
     */   
    public function showajaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form_name = $request->get('form_name');
        $id = $request->get('id');        
        
        $arreglo = $this->showEntidad($form_name, $id);
        
        $form_name_lowcase = strtolower($form_name);
        $edit = $this->generateUrl($form_name_lowcase.'_edit', array('id' => $id));
        $delete = $this->generateUrl($form_name_lowcase.'_delete', array('id' => $id));        
        
        $objeto = '<div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-green">
                                        <i class="icon-settings font-green"></i>
                                        <span class="caption-subject bold uppercase">Show</span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group" id="myDropdown">
                                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="'.$edit.'">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="'.$delete.'"><i class="fa fa-trash-o"></i> Delete </a> 
                                                </li>
                                            </ul>
                                        </div>
                                    </div>                                    
                                </div>   
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">';
        
        foreach ($arreglo as $key => $val) {
            $objeto .= '<tr><td width="40%"><strong>'.$key.': </strong></td><td>'.$val.'</td></tr>';
        }
                                        
        $objeto .= '</tbody></table></div></div>';
        
        return new JsonResponse($objeto);
    }    
    
    public function showEntidad($form_name, $id){  
        $em = $this->getDoctrine()->getManager();

        $modelo = 'SGIBundle:'.$form_name;
        
        $form = $em->getRepository($modelo)
                ->findOneBy(array('id' => $id));
        
        $arreglo = array();
        
        switch ($form_name) {
            case 'FieldsComtrad':
                $trackable = $form->getTrackable() ? "True":"False";
                $arreglo =  array('Id' => $id,'Description' => $form->getDescription(),
                    'Widget' => $form->getWiget(), 'Trackable' => $trackable);
                break;
            case 'TypeComtrad':
                $arreglo =  array('Id' => $id,'Description' => $form->getDescription());
                break;            
        }
        
        
        return $arreglo; 
    }    
}

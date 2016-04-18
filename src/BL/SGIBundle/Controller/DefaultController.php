<?php

namespace BL\SGIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\Query;
use Symfony\Component\Validator\Constraints\DateTime;
use BL\SGIBundle\Entity\Bl;
use BL\SGIBundle\Entity\Altinv;
use BL\SGIBundle\Entity\TrackAltinv;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SGIBundle:Default:index.html.twig');
    }
    
    public function gridAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsComtradstrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => true));
        $serializer = $this->container->get('serializer');
        $fctracks= $serializer->serialize($fieldsComtradstrackable, 'json');

        $fieldsComtradsnotrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => false));
        $serializer = $this->container->get('serializer');
        $fcnotracks= $serializer->serialize($fieldsComtradsnotrackable, 'json');

        return $this->render('SGIBundle:Default:griddos.html.twig', array(
            'fctracks' => $fctracks,'fcnotracks' => $fcnotracks
        ));
    }




    public function griddosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsComtradstrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => true));
        $serializer = $this->container->get('serializer');
        $fctracks= $serializer->serialize($fieldsComtradstrackable, 'json');

        $fieldsComtradsnotrackable = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => false));
        $serializer = $this->container->get('serializer');
        $fcnotracks= $serializer->serialize($fieldsComtradsnotrackable, 'json');

        return $this->render('SGIBundle:Default:griddos.html.twig', array(
            'fctracks' => $fctracks,'fcnotracks' => $fcnotracks
        ));
    }

    public function calendarAction()
    {
        return $this->render('SGIBundle:Default:calendar.html.twig');
    }
    
    
    public function mapAction()
    {
        return $this->render('SGIBundle:Default:map.html.twig');
    }
    
    
    public function ajax_graphAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
       
        $model=$request->get('model');
        $track_field=$request->get('track_field');
        
     
        $fields=$em->getRepository('SGIBundle:TrackAltinv')
                ->findBy(
                    array('idFieldsTrackAltinv'=> $track_field),
                    array('idFieldsTrackAltinv' => 'ASC')
            );
                
                
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($fields, 'json');
        
        
        return new Response($objects);
        //return new JsonResponse(($object));
    }
    
}

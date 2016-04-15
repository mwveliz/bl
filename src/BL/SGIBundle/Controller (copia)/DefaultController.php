<?php

namespace BL\SGIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    
    
}

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

        $fieldsComtrads = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => true));


        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($fieldsComtrads , 'json');



        return $this->render('SGIBundle:Default:griddos.html.twig', array(
            'reports' => $reports,
        ));
    }




    public function griddosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fieldsComtrads = $em->getRepository('SGIBundle:FieldsComtrad')->findBy(array('trackable' => true));


        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($fieldsComtrads , 'json');



        return $this->render('SGIBundle:Default:griddos.html.twig', array(
            'reports' => $reports,
        ));
    }

    public function calendarAction()
    {
        return $this->render('SGIBundle:Default:calendar.html.twig');
    }
    
    
}

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
        return $this->render('SGIBundle:Default:grid.html.twig');
    }


    public function griddosAction()
    {
        return $this->render('SGIBundle:Default:grid.html.twig');
    }

    public function calendarAction()
    {
        return $this->render('SGIBundle:Default:calendar.html.twig');
    }
    
    
}

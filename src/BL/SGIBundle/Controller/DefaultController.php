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
use BL\SGIBundle\Entity\State;


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
    
    
    /**
     * amCharts Generation via ajax
    */
    
    public function ajax_graphAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
       
        $model=$request->get('model');
        $track_field=$request->get('track_field');
    
       $table='SGIBundle:'.$model;
        
        
    // $campos = array('d.value', 'd.datetime', 'o.id');
    //$fields = 'partial d.{id, name}, partial o.{id}';  //if you want to get entity object
         $campos = array('t.value', 't.datetime');
        $query = $em->createQueryBuilder();
        $query
            ->select($campos)
            ->from($table, 't')
            //->leftjoin('d.otherEntity', 'o');
            ->where('t.idFieldsTrackAltinv= :track_field')
            ->setParameter('track_field', $track_field)
            ->add('orderBy','t.datetime ASC');    
        //$query->setMaxResults(10);
        $registros= $query->getQuery()->getResult();
     
       /* $fields=$em->getRepository('SGIBundle:TrackAltinv')
                ->findBy(
                    array('idFieldsTrackAltinv'=> $track_field),
                    array('idFieldsTrackAltinv' => 'ASC')
            );
         */       
   
        //cambios los nombres de los indices para que pueda verse
        foreach ( $registros as $k=>$v )
        {
            /*primero el eje de tiempo*/
            $fecha=$registros[$k]['datetime']->format('Y-m-d H:i:s');
            $registros[$k] ['date'] = substr($fecha,0,7);
            
            /**luego la(s) serie(s) de valores, debo calcular matriz*/
            $valor=$registros[$k]['value'];
            $registros[$k] ['serie1'] = floatval($valor);
            
            unset($registros[$k]['datetime']);
            unset($registros[$k]['value']);
        }
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($registros, 'json');
        
        return new Response($objects);
        //return new JsonResponse(($object));
    }
    
    
    
    /**
     *Map Generation via ajax
    */
    public function ajax_mapAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
       
       $model=$request->get('model');
       $opportunity=$request->get('opportunity');//type
       $account=$request->get('bl_code');//id_bl
    
       
       $table='SGIBundle:'.$model;
        
        
    // $campos = array('d.value', 'd.datetime', 'o.id');
    //$fields = 'partial d.{id, name}, partial o.{id}';  //if you want to get entity object
        $campos = array('o.description', 't.idState','t.description');
        $query = $em->createQueryBuilder();
        $query
            ->select('o')
            ->from($table, 't')
            ->Join('SGIBundle:State', 'o')
             ->where('o.id= t.idState ');
            //->where('t.idFieldsTrackAltinv= :track_field')
            //->setParameter('track_field', $track_field)
            //->add('orderBy','t.idStateASC');    
        //$query->setMaxResults(10);
        $registros= $query->getQuery()->getArrayResult();
     
       /* $fields=$em->getRepository('SGIBundle:TrackAltinv')
                ->findBy(
                    array('idFieldsTrackAltinv'=> $track_field),
                    array('idFieldsTrackAltinv' => 'ASC')
            );
         */       
   
        
        //cambios los nombres de los indices para que pueda verse
        foreach ( $registros as $k=>$v )
        {
            /*primero el coidgo de pais*/
            $code=$registros[$k]['descriptionCountry'];
            $registros[$k] ['name'] = $code;
            
            /**luego cuento o imprimoel estado*/
            $z=$registros[$k]['id'];
            $registros[$k] ['z'] = $z;
            
           unset($registros[$k]['descriptionCountry']);
            unset($registros[$k]['id']);
            unset($registros[$k]['description']);
        }
        $serializer = $this->container->get('serializer');
        $objects= $serializer->serialize($registros, 'json');
        
        return new Response($objects);
        //return new JsonResponse(($object));
    }
    
      /**
     *Admin charts position thru drag n drop
    */
    
      public function admin_chartsAction(Request $request)
    {
       
       return $this->render('SGIBundle:Default:admin_charts.html.twig');
        //return new JsonResponse(($object));
    }
    
}

<?php

namespace BL\SGIBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BL\SGIBundle\Entity\BlSeller;
use BL\SGIBundle\Entity\Bl;
use BL\SGIBundle\Entity\Altinv;
use BL\SGIBundle\Entity\Comtrad;
use BL\SGIBundle\Entity\Constru;
use BL\SGIBundle\Entity\Rental;
use BL\SGIBundle\Entity\Usuario;
use BL\SGIBundle\Form\BlSellerType;
use BL\SGIBundle\Form\UsuarioType;
use FOS\UserBundle\Model\GroupableInterface;
/**
 * BlSeller controller.
 *
 * @Route("/blseller")
 */
class BlSellerController extends Controller
{
    /**
     * Lists all BlSeller entities.
     *
     * @Route("/", name="blseller_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
         $userManager = $this->container->get('fos_user.user_manager');
         
        $users = $userManager->findUsers();

        return $this->render('blseller/index.html.twig', array(
            'usuarios' =>$users,
        ));
    }

    /**
     * Creates a new BlSeller entity.
     *
     * @Route("/new", name="blseller_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blSeller = new BlSeller();
        $form = $this->createForm('BL\SGIBundle\Form\BlSellerType', $blSeller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blSeller);
            $em->flush();

            return $this->redirectToRoute('blseller_show', array('id' => $blseller->getId()));
        }

        return $this->render('blseller/new.html.twig', array(
            'blSeller' => $blSeller,
            'form' => $form->createView(),
        ));
    }

    
    /**
     * Creates a new BlSeller entity.
     *
     * @Route("/blsellerusuarionew", name="blseller_usuarionew")
     * @Method({"GET", "POST"})
     */
    public function usuarionewAction(Request $request)
    {
        $usuario= new Usuario();
        
        $form = $this->createForm('BL\SGIBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            
            
            $em->flush();
            //falta agregar registo de blseller
            $id = $usuario->getId(); //obtengo el id del vendedor para asociarle las accounts
            //agrego le seller a la tabla de grupo y arreglo el rol
            $userManager = $this->container->get('fos_user.user_manager');
            $usuario->addRole('ROLE_SELLER');
            $userManager->updateUser($usuario);
            $usuario->addGroup($em->getReference('BL\SGIBundle\Entity\Group', 2));//agrego el usuario como vendedor
            $userManager->updateUser($usuario);
            
              $arreglo = $_POST["EF_account"];
             foreach ($arreglo as $key => $value) {
                 $blSeller = new BlSeller();
                  $id_usuario = $em->getReference('BL\SGIBundle\Entity\Usuario', $id);
                  $id_bl= $em->getReference('BL\SGIBundle\Entity\Bl', $key);
                  $blSeller->setIdUsuario($id_usuario );
                  $blSeller->setIdBl($id_bl);
                  $blSeller->setDateStart(new \DateTime);
                    $em->persist($blSeller);
                    $em->flush();
                 
             }
            return $this->redirectToRoute('blseller_index');
        }

        return $this->render('blseller/new_usuarioseller.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Show client in the right side via ajax.
     *
     * @Route("/accountsperseller", name="blseller_dashboard")
     * @Method("GET")
     */
    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $usuario=$em->getRepository('SGIBundle:Usuario')->findOneById($id);
        $seller=$em->getReference('BL\SGIBundle\Entity\Usuario',$id );
        
        
        /******bloque altinvs******/
        $id_altinvs=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:Bl f')
             ->innerJoin('SGIBundle:BlSeller', 'b')
             ->where('f.id=b.idBl')
             ->andWhere('b.idUsuario = :idusuario ')
             ->andWhere('f.type= :type ')
             ->setParameter('idusuario', $id)
             ->setParameter('type', 'altinv')
             ->add('orderBy','f.type ASC')
             ->getQuery()
             ->getResult();
        $array_idaltinvs=array();
        foreach($id_altinvs as $registro){
             array_push($array_idaltinvs, $registro->getId())   ;
        }
        $array_altinvs=$em->createQueryBuilder('c')
             ->add('select','c')
             ->add('from', 'SGIBundle:Altinv c')
             ->innerJoin('SGIBundle:Bl', 'f')
             ->where('c.id=f.codeBl')
             ->andWhere("f.id IN(:ids)")
             ->setParameter('ids', $array_idaltinvs)
             ->getQuery()
             ->getResult();
        /****fin bloque altinvs***/
        
        
        /******bloque comtrads******/
        $id_comtrads=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:Bl f')
             ->innerJoin('SGIBundle:BlSeller', 'b')
             ->where('f.id=b.idBl')
             ->andWhere('b.idUsuario = :idusuario ')
             ->andWhere('f.type= :type ')
             ->setParameter('idusuario', $id)
             ->setParameter('type', 'comtrad')
             ->add('orderBy','f.type ASC')
             ->getQuery()
             ->getResult();
       
        $array_idcomtrads=array();
        foreach($id_comtrads as $registro){
             array_push($array_idcomtrads, $registro->getId())   ;
        }
        $array_comtrads=$em->createQueryBuilder('c')
             ->add('select','c')
             ->add('from', 'SGIBundle:Comtrad c')
             ->innerJoin('SGIBundle:Bl', 'f')
             ->where('c.id=f.codeBl')
             ->andWhere("f.id IN(:ids)")
             ->setParameter('ids', $array_idcomtrads)
             ->getQuery()
             ->getResult();
        
        /****fin bloque comtrads***/
        
       /******bloque construs******/
        $id_construs=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:Bl f')
             ->innerJoin('SGIBundle:BlSeller', 'b')
             ->where('f.id=b.idBl')
             ->andWhere('b.idUsuario = :idusuario ')
             ->andWhere('f.type= :type ')
             ->setParameter('idusuario', $id)
             ->setParameter('type', 'constru')
             ->add('orderBy','f.id DESC')
             ->getQuery()
             ->getResult();
         $array_idconstrus=array();
        foreach($id_construs as $registro){
             array_push($array_idconstrus, $registro->getId())   ;
        }
        $array_construs=$em->createQueryBuilder('c')
             ->add('select','c')
             ->add('from', 'SGIBundle:Constru c')
             ->innerJoin('SGIBundle:Bl', 'f')
             ->where('c.id=f.codeBl')
             ->andWhere("f.id IN(:ids)")
             ->setParameter('ids', $array_idconstrus)
             ->getQuery()
             ->getResult();
         /****fin bloque construs***/
        
         /******bloque rentals******/
        $id_rentals=$em->createQueryBuilder('f')
             ->add('select','f')
             ->add('from', 'SGIBundle:Bl f')
             ->innerJoin('SGIBundle:BlSeller', 'b')
             ->where('f.id=b.idBl')
             ->andWhere('b.idUsuario = :idusuario ')
             ->andWhere('f.type= :type ')
             ->setParameter('idusuario', $id)
             ->setParameter('type', 'rental')
             ->add('orderBy','f.id DESC')
             ->getQuery()
             ->getResult();
           $array_idrentals=array();
        foreach($id_rentals as $registro){
             array_push($array_idrentals, $registro->getId())   ;
        }
        $array_rentals=$em->createQueryBuilder('c')
             ->add('select','c')
             ->add('from', 'SGIBundle:Rental c')
             ->innerJoin('SGIBundle:Bl', 'f')
             ->where('c.id=f.codeBl')
             ->andWhere("f.id IN(:ids)")
             ->setParameter('ids', $array_idrentals)
             ->getQuery()
             ->getResult();
     
        
        
         /****fin bloque construs***/
     $array_subtotal1 =array_merge($array_altinvs,$array_comtrads); 
     $array_subtotal2 =array_merge($array_construs,$array_rentals); 
     $accounts = array_merge($array_subtotal1,$array_subtotal2);
      
   
        return $this->render('blseller/dashboard.html.twig', array(
            'accounts' => $accounts, 
        ));
    }
    
    
    /**
     * Show client in the right side via ajax.
     *
     * @Route("/ajaxshow", name="blseller_ajaxshow")
     * @Method("GET")
     */
    public function ajaxshowAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $usuario=$em->getRepository('SGIBundle:Usuario')->findOneById($id);
        $seller=$em->getReference('BL\SGIBundle\Entity\Usuario',$id );
        
        $blseller= $em->getRepository('SGIBundle:BlSeller')->findOneByIdUsuario($seller);
        //die(var_dump($seller));
        //$em->getReference('BL\SGIBundle\Entity\Usuario', 2
        
        
        $deleteForm = $this->createDeleteForm($blseller);

        return $this->render('blseller/ajax_show.html.twig', array(
            'delete_form' => $deleteForm->createView(),
            'blSeller' => $blseller,
             'usuario' => $usuario  
        ));
    }
    
    /**
     * Finds and displays all Accounts from BL: Altinv, Comtrad, Constru, Rental.
     *
     * @Route("/showaccounts", name="blseller_showaccounts")
     * @Method("GET")
     */
    public function showaccountsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $bl = $em->getRepository('SGIBundle:Bl')->findAll();
        return $this->render('blseller/ajaxaccount_list.html.twig', array(
            'accounts' => $bl,
        ));
    }

    
    /**
     * Finds and displays a BlSeller entity.
     *
     * @Route("/{id}", name="blseller_show")
     * @Method("GET")
     */
    public function showAction(BlSeller $blSeller)
    {
        $deleteForm = $this->createDeleteForm($blSeller);

        return $this->render('blseller/show.html.twig', array(
            'blSeller' => $blSeller,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
     
    /**
     * Displays a form to edit an existing BlSeller entity.
     *
     * @Route("/{id}/edit", name="blseller_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
          
        $blSeller = new BlSeller();
        //$deleteForm = $this->createDeleteForm($blSeller);
        
        $editForm = $this->createForm('BL\SGIBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('blseller_index');
        }

        return $this->render('blseller/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BlSeller entity.
     *
     * @Route("/{id}", name="blseller_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlSeller $blSeller)
    {
        $form = $this->createDeleteForm($blSeller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blSeller);
            $em->flush();
        }

        return $this->redirectToRoute('blseller_index');
    }

    /**
     * Creates a form to delete a BlSeller entity.
     *
     * @param BlSeller $blSeller The BlSeller entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlSeller $blSeller)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blseller_delete', array('id' => $blSeller->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

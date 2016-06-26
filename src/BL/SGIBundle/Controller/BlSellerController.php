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

        $blSellers = $em->getRepository('SGIBundle:BlSeller')->findAll();

        return $this->render('blseller/index.html.twig', array(
            'blSellers' => $blSellers,
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
     * @Route("/ajaxshow", name="blseller_ajaxshow")
     * @Method("GET")
     */
    public function ajaxshowAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->get('id');
        $client = $em->getRepository('SGIBundle:BlSeller')->findOneById($id); 
        
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('blseller/ajax_show.html.twig', array(
            'delete_form' => $deleteForm->createView(),
            'client' => $client
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
    public function editAction(Request $request, BlSeller $blSeller)
    {
        $deleteForm = $this->createDeleteForm($blSeller);
        $editForm = $this->createForm('BL\SGIBundle\Form\BlSellerType', $blSeller);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blSeller);
            $em->flush();

            return $this->redirectToRoute('blseller_edit', array('id' => $blSeller->getId()));
        }

        return $this->render('blseller/edit.html.twig', array(
            'blSeller' => $blSeller,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class TodoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userid','entity_typeahead', array(
                'label' => 'Assigned to',
                'class' => 'SGIBundle:Usuario',
                'render' => 'userid',
                'route' => 'user_index_ajax',
                'attr' => array(
                    'class' => 'form-control form-group'
                 ),                
            ))    
            ->add('idBl','entity_typeahead', array(
                'label' => 'Business Line',
                'class' => 'SGIBundle:Bl',
                'render' => 'id_bl',
                'route' => 'bl_index_ajax',
                'attr' => array(
                    'class' => 'form-control form-group'
                 ),                
            ))                
            ->add('description', 'text', array(
                 'attr' => array('class' => 'form-control input-sm')
             ))
            ->add('IdPriority', 'entity', array(
                    'label' => 'Priority',
                    'class' => 'SGIBundle:TodoPriority',
                    'attr' => array(
                        'class' => 'form-control form-group'
                     ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('x')
                               ->orderBy('x.description', 'ASC');
                    },
            ))   
            ->add('completed', 'checkbox', array(
                   'attr' => array('class' => 'checkbox-list'),
                   'required' => false,
             ))                             
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\SGIBundle\Entity\Todo'
        ));
    }
}

<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ConstruType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('idState','entity_typeahead', array(
                'label' => 'State',
                'class' => 'SGIBundle:State',
                'render' => 'id_state',
                'route' => 'state_index_ajax',
                'attr' => array(
                    'class' => 'form-control form-group'
                ),
            ))
            ->add('idClient','entity_typeahead', array(
                'label' => 'Client',
                'class' => 'SGIBundle:Client',
                'render' => 'id_client',
                'route' => 'client_index_ajax',
                'attr' => array(
                    'class' => 'form-control form-group'
                ),
            ))

            ->add('description', 'text', array(
                'attr' => array('class' => 'form-control input-sm')
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\SGIBundle\Entity\Constru'
        ));
    }
}

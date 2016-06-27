<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PipelineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', array(
                'label' => 'Description',
                'attr' => array(
                    'class' => 'form-control input-md'
                )
             ))
          ->add('idBl','entity_typeahead', array(
                'label' => 'Account for pipeline',
                'class' => 'SGIBundle:Bl',
                'render' => 'description',
                'route' => 'ajax_blaccounts',
                'attr' => array(
                    'class' => 'form-control form-group'
                ),
            ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\SGIBundle\Entity\Pipeline'
        ));
    }
}

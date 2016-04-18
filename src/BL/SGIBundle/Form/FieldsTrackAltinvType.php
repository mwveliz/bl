<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldsTrackAltinvType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
          /*  ->add('sign', 'choice', array(
             'attr' => array('class' => 'form-control form-group'),   
             'label' => 'Sign',   
             'choices' => array('Creditor (+) ' => 'positive', 'Debitor (-)' => 'negative'), 
             ))*/      
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\SGIBundle\Entity\FieldsTrackAltinv'
        ));
    }
}

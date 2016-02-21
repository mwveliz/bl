<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldsComtradType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', array(
                 'attr' => array('class' => 'form-control input-sm')
             ))   
                
            ->add('wiget', 'choice', array(
             'attr' => array('class' => 'form-control form-group'),   
             'label' => 'Widget',   
             'choices' => array('Calendar' => 'Calendar', 'Characters' => 'Characters', 
                 'Currency' => 'Currency', 'File' => 'File', 
                 'TextArea' => 'TextArea', 'Numeric' => 'Numeric'),
             ))             
            ->add('trackable', 'checkbox', array(
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
            'data_class' => 'BL\SGIBundle\Entity\FieldsComtrad'
        ));
    }
}

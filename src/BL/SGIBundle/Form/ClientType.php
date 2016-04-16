<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array('class' => 'form-control input-sm')
            ))
            ->add('lastname', 'text', array(
                'attr' => array('class' => 'form-control input-sm')
            ))    
            ->add('treatment', 'text', array(
                'attr' => array('class' => 'form-control input-sm')
            ))    
            ->add('address', 'textarea', array(
                'attr' => array('class' => 'form-control', 'rows'=>'3')
            ))
            ->add('contact', 'text', array(
                'attr' => array('class' => 'form-control input-sm')
            ))    
            ->add('emailOne', 'text', array(
                'attr' => array('class' => 'form-control input-xs')
            ))    
            ->add('emailTwo', 'text', array(
                'attr' => array('class' => 'form-control input-sm')
            ))    
            ->add('legalId', 'text', array(
                'attr' => array('class' => 'form-control input-xs')
            ))
             
            //->add('logo')
            //->add('picture')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\SGIBundle\Entity\Client'
        ));
    }
}

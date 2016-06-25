<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                 ->add('username', null, array(
                'attr' => array('class' => 'form-control input-sm'),
                'label' => 'Username', 
                'translation_domain' => 'FOSUserBundle'))                            
           
            ->add('nacionalidad', 'choice', array(
                'label' => 'Nationality', 
                'attr' => array('class' => 'form-control form-group'),	
                'choices' => array('V' => 'V', 'E' => 'E'),
            ))                
            ->add('dni', 'integer', array(
                'label' => 'DNI',
                'attr' => array('class' => 'form-control input-sm',
                                'placeholder' => 'e.g.: 10456789',
                                )
            ))    
            ->add('nombre', 'text', array(
                'label' => 'Name(s)',
                'attr' => array(
                    'class' => 'form-control input-sm'
                )
                    )
            )
            ->add('apellido', 'text', array(
                'label' => 'Last Name(s)',
                'attr' => array(
                    'class' => 'form-control input-sm'
                )
                    )
            )
            ->add('email', 'email', 
                    array('label' => 'e-Mail', 
                        'attr' => array(
                            'class' => 'form-control input-sm'
                        ),
                        'translation_domain' => 'FOSUserBundle')
                 )    
            ->add('telefono', 'text', array(
                'label' => 'Main Phone Number',
                'attr' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => 'e.g.: +58-212-781-2711',
                )
                    )
            )
            ->add('telefono_secundario', 'text', array(
                'label' => 'Secondary Phone Number',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control input-sm',
                    'placeholder' => 'e.g.: +58-212-781-2711',
                )
                    )
            )                 
           
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Password','attr' => array('class' => 'form-control input-sm')),
                'second_options' => array('label' => 'Password confirmation','attr' => array('class' => 'form-control input-sm'),),
                'invalid_message' => 'fos_user.password.mismatch',
            )) 
            ->add('enabled', 'checkbox', array(
                'label' => 'Is Active?',
                'attr' => array(
                    'class' => 'checkbox'
                ),
                'required' => false,
                'data' => true,
            ));    
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\SGIBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bl_sgibundle_usuario';
    }
}

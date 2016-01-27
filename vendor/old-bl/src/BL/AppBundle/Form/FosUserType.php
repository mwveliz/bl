<?php

namespace BL\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FosUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dni')
            ->add('nacionalidad')
            ->add('nombre')
            ->add('apellido')
            ->add('telefono')
            ->add('telefonoSecundario')
            ->add('idFosUserinfo')
            ->add('fosUsername')
            ->add('fosUsernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin', 'datetime')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt', 'datetime')
            ->add('confirmationToken')
            ->add('passwordRequestedAt', 'datetime')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt', 'datetime')
            ->add('group')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BL\AppBundle\Entity\FosUser'
        ));
    }
}

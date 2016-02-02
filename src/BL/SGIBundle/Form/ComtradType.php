<?php

namespace BL\SGIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class ComtradType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('IdTypeComtrad', 'entity', array(
                    'label' => 'Type of Commodity Trading',
                    'class' => 'SGIBundle:TypeComtrad',
                    'attr' => array(
                        'class' => 'form-control form-group'
                     ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('x')
                               ->orderBy('x.description', 'ASC');
                    },
            ))     
                            
                            
            ->add('idState')
            ->add('idClient','entity_typeahead', array(
                'class' => 'SGIBundle:User',
                'render' => 'id_client',
                'route' => 'client_index_ajax',
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
            'data_class' => 'BL\SGIBundle\Entity\Comtrad'
        ));
    }
}

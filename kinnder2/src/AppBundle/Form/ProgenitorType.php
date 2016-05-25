<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProgenitorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('direccion')
            ->add('telefono')
            ->add('celular')
            ->add('oldId')
            ->add('cuenta')
            ->add('estudiantes')
            ->add('user_roles')
            ->add('newsletterUser')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Progenitor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_progenitor';
    }
}

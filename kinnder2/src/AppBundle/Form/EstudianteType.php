<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstudianteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('fechaNacimiento')
            ->add('anioIngreso')
            ->add('sociedad')
            ->add('referenciaBancaria')
            ->add('emergenciaMedica')
            ->add('horario')
            ->add('futuroColegio')
            ->add('descuento')
            ->add('clase')
            ->add('egresado')
            ->add('actividades')
            ->add('cuentas')
            ->add('brothersWithMe')
            ->add('myBrothers')
            ->add('progenitores')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Estudiante'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_estudiante';
    }
}

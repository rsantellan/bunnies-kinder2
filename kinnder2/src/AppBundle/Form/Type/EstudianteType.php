<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstudianteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('fechaNacimiento', null, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
              ))
            ->add('anioIngreso', null, array(
                'data' => date('Y'),
            ))
            ->add('sociedadMedica')
            ->add('referenciaBancaria')
            ->add('emergenciaMedica')
            ->add('horario')
            ->add('futuroColegio')
            ->add('descuento')
            ->add('clase')
            ->add('egresado')
            ->add('actividades', null, array(
                'expanded' => true,
            ))
            //->add('cuentas')
            //->add('brothersWithMe')
            //->add('myBrothers')
            //->add('progenitores')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Estudiante',
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

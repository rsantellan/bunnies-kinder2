<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddFacturaDetalleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea')
            ->add('amount', 'number')
            ->add('alumnos', 'choice', array(
                'choices' => $options['alumnos']
            ))
            //->add('createdAt')
            //->add('updatedAt')
            //->add('factura')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'AppBundle\Entity\FacturaEstudianteDetalle'
            'alumnos' => array(),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_addfacturadetalle';
    }
}

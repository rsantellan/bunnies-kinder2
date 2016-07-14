<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AddFacturaDetalleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('amount', 'integer', array(
                'constraints' => array(
                    new NotBlank(),
                    new Regex(array('pattern' => "/\d+/")),
                ),
            ))
            ->add('alumnos', 'choice', array(
                'choices' => $options['alumnos'],
            ))
            //->add('createdAt')
            //->add('updatedAt')
            //->add('factura')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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

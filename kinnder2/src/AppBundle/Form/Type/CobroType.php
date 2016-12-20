<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CobroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('fecha')
            ->add('fecha', null, array(
                     'widget' => 'single_text',
                     'format' => 'dd-MM-yyyy',
            ))
            ->add('monto', 'Symfony\Component\Form\Extension\Core\Type\IntegerType')
            //->add('cancelado')
            ->add('enviado')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('cuenta')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cobro',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cobro';
    }
}

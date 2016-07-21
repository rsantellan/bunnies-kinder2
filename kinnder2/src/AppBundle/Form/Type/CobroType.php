<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('monto')
            //->add('cancelado')
            ->add('enviado')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('cuenta')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cobro',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_cobro';
    }
}

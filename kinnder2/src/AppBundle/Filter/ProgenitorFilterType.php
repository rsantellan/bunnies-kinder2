<?php

namespace AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * Description of ProgenitorFilterType.
 *
 * @author Rodrigo Santellan
 */
class ProgenitorFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH,
              ));
        $builder->add('email', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH,
              ));
    }

    public function getBlockPrefix()
    {
        return 'progenitor_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'csrf_protection' => false,
          'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
      ));
    }
}

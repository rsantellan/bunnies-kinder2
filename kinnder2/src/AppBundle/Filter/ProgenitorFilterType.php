<?php

namespace AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * Description of ProgenitorFilterType
 *
 * @author Rodrigo Santellan
 */
class ProgenitorFilterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('referenciaBancaria', 'filter_text');
      $builder->add('nombre', 'filter_text',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH
              ));
      $builder->add('email', 'filter_text',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH
              ));
  }
    
  public function getName() {
    return 'progenitor_filter';
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'csrf_protection'   => false,
          'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
      ));
  }
}

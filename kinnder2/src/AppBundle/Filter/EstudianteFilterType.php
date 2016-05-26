<?php

namespace AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * Description of EstudianteFilterType.
 *
 * @author Rodrigo Santellan
 */
class EstudianteFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('referenciaBancaria', 'filter_text');
        $builder->add('apellido', 'filter_text',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH,
              ));
        $builder->add('nombre', 'filter_text',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH,
              ));
        $builder->add('clase', 'filter_entity',
                    array(
                    'required' => false,
                    'class' => 'AppBundle\Entity\Clase',
                    'empty_value' => 'Todos',
                     ));
        $builder->add('horario', 'filter_entity',
                    array(
                    'required' => false,
                    'class' => 'AppBundle\Entity\Horario',
                    'empty_value' => 'Todos',
                     ));
        $builder->add('actividades', 'filter_entity',
                    array(
                    'required' => false,
                    'class' => 'AppBundle\Entity\Actividad',
                    'empty_value' => 'Todos',
                     )
                   );
    }

    public function getName()
    {
        return 'estudiante_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'csrf_protection' => false,
          'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
      ));
    }
}

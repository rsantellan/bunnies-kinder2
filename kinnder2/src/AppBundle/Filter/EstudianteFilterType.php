<?php

namespace AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

/**
 * Description of EstudianteFilterType.
 *
 * @author Rodrigo Santellan
 */
class EstudianteFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('referenciaBancaria', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType');
        $builder->add('apellido', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH,
              ));
        $builder->add('nombre', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType',
              array(
                  'condition_pattern' => FilterOperands::STRING_BOTH,
              ));
        $builder->add('clase', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType',
                    array(
                    'required' => false,
                    'class' => 'AppBundle\Entity\Clase',
                    'placeholder' => 'Todos',
                     ));
        $builder->add('horario', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType',
                    array(
                    'required' => false,
                    'class' => 'AppBundle\Entity\Horario',
                    'placeholder' => 'Todos',
                     ));
        $builder->add('actividades', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType',
                    array(
                    'required' => false,
                    'class' => 'AppBundle\Entity\Actividad',
                    'placeholder' => 'Todos',
                    'apply_filter'  => function (QueryInterface $filterQuery, $field, $values)
                      {
                          $query = $filterQuery->getQueryBuilder();
                          $query->innerJoin($field, 't');
                          $value = $values['value'];
                          if (isset($value)){
                              $paramName = sprintf('p_%t', str_replace('.', '_', $field));
                              $expression = $filterQuery->getExpr()->eq("t.id", ':'.$paramName);
                              $parameters = array($paramName => $values['value']->getId()); 
                              return $filterQuery->createCondition($expression, $parameters);
                          }
                      },
                     )
                   );
    }

    public function getBlockPrefix()
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

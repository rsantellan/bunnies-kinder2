<?php

namespace AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of EstudianteFilterType
 *
 * @author Rodrigo Santellan
 */
class EstudianteFilterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('referenciaBancaria', 'filter_text');
      $builder->add('apellido', 'filter_text');
      $builder->add('nombre', 'filter_text');
      $builder->add('clase', 'filter_text');
      $builder->add('horario', 'filter_text');
      $builder->add('actividades', 'filter_entity',
                    array(
					'required' => false,
                    'class' => 'AppBundle\Entity\Actividad',
                    'empty_value' => 'Todos',
                    /*    
                    'query_builder' => function($repository){
                        return $repository->createQueryBuilder('t')->where('t.entidadContribuyente = :dgi')->setParameter(':dgi', 'DGI');
                      }
                      */
                     )
                   );
  }
    
  public function getName() {
    return 'estudiante_filter';
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'csrf_protection'   => false,
          'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
      ));
  }
}

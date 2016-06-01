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
class EstudianteExportFilterType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    $camposUsuario = array(
        'nombre' => 'Nombre',
        'apellido' => 'Apellido',
        'fecha_nacimiento' => 'Fecha Nacimiento',
        'anio_ingreso' => 'Año de ingreso',
        'sociedad' => 'Sociedad',
        'referencia_bancaria' => 'Referencia',
        'emergencia_medica' => 'Emergencia Medica',
        'horario' => 'Horario',
        'futuro_colegio' => 'Futuro Colegio',
        'clase' => 'clase',
    );

    $camposPadres = array(
        'padre' => 'nombre',
        'direccion' => 'Dirección',
        'telefono' => 'Teléfono',
        'celular' => 'Celular',
        'mail' => 'Correo Electronico',
    );

    $exportar = array('1' => 'Si', '0' => 'No');

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

     $builder->add('estudiantes', 'filter_choice',
                 array(
                 'required' => false,
                 'choices' => $camposUsuario,
                 'expanded' => true,
                 'multiple' => true,
                  ));
     $builder->add('padres', 'filter_choice',
                 array(
                 'required' => false,
                 'choices' => $camposPadres,
                 'expanded' => true,
                 'multiple' => true,
                  ));
     $builder->add('exportar', 'filter_choice',
                 array(
                 'required' => false,
                 'choices' => $exportar,
                 'expanded' => true,
                 'multiple' => true,
                  ));
  }

  public function getName()
  {
      return 'estudiante_export_filter';
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
        'csrf_protection' => false,
        'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
    ));
  }

}

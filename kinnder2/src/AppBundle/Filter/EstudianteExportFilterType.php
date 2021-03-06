<?php

namespace AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

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
        'fechaNacimiento' => 'Fecha Nacimiento',
        'anioIngreso' => 'Año de ingreso',
        'sociedadMedica' => 'Sociedad',
        'referenciaBancaria' => 'Referencia',
        'emergenciaMedica' => 'Emergencia Medica',
        'horario' => 'Horario',
        'futuro_colegio' => 'Futuro Colegio',
        'clase' => 'Clase',
    );

        $camposPadres = array(
        'progenitor' => 'Nombre',
        'direccion' => 'Dirección',
        'telefono' => 'Teléfono',
        'celular' => 'Celular',
        'email' => 'Correo Electronico',
    );

        $exportar = array('0' => 'No', '1' => 'Si');

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

        $builder->add('estudiantes', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType',
                 array(
                 'required' => false,
                 'choices' => $camposUsuario,
                 'expanded' => true,
                 'multiple' => true,
                 'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                        return;
                     },
                  ));
        $builder->add('padres', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType',
                 array(
                 'required' => false,
                 'choices' => $camposPadres,
                 'expanded' => true,
                 'multiple' => true,
                 'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                        return;
                     },
                  ));
        $builder->add('exportar', 'Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType',
                 array(
                 'required' => true,
                 'choices' => $exportar,
                 'expanded' => false,
                 'multiple' => false,
                 'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                        return;
                     },
                  ));
    }

    public function getBlockPrefix()
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

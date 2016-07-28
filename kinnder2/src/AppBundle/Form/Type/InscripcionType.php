<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Description of ContactType
 *
 * @author Rodrigo Santellan
 */
class InscripcionType extends AbstractType
{
  
  public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'pattern' => '.{2,}', //minlength
                ),
            ))->add('lastname', 'text', array(
                'attr' => array(
                    'pattern' => '.{2,}', //minlength
                ),
                'required' => false,
            ))
            ->add('email', 'email', array(
                'attr' => array(
                ),
            ))
            ->add('phone', 'text', array(
                'attr' => array(
                ),
                'required' => false,
            ))
            ->add('colegio', 'entity', array(
                'class' => 'AppBundle:Colegio'
            ))    
            ->add('horario', 'entity', array(
                'class' => 'AppBundle:Horario'
            ))    
            ->add('fechanacimiento', 'date', array(
                'required' => true,
                'widget' => 'single_text',
            ))    
            ->add('address', 'text', array(
                'required' => false,
            ))    
            ->add('message', 'textarea', array(
                'attr' => array(
                    'rows' => 10,
                ),
            ));
            $builder->add('captcha', 'captcha', array(
                'as_url' => '1',
                'reload' => true,
                
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'El nombre no puede estar vacio')),
                new Length(array('min' => 2)),
            ),
            'lastname' => array(
                new NotBlank(array('message' => 'El apellido no puede estar vacio')),
                new Length(array('min' => 2)),
            ),
            'email' => array(
                new NotBlank(array('message' => 'El E-Mail no puede estar vacio')),
                new Email(array('message' => 'Dirección de correo invalida.')),
            ),
            'phone' => array(),
            'fechanacimiento' => array(),
            'address' => array(),
            'horario' => array(),
            'colegio' => array(),
            'message' => array(
                new NotBlank(array('message' => 'El mensaje no puede estar vacio')),
                new Length(array('min' => 5)),
            ),
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint,
        ));
    }

    public function getName()
    {
        return 'appbundle_inscripciontype';
    }
}

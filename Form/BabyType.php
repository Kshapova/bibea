<?php

namespace KSH\BibeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BabyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('psedo')
            ->add('name')
            ->add('surname')
            ->add('imageFile',  'file', array (
                    'required' => false)) // Ajoutez l'image
            ->add('birthDate', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                ))
            ->add('sex', 'choice', array(
                                'choices' => array(
                                    'F' => 'Fille',
                                    'M' => 'Garçon',    
                                ),
                                'multiple'  => false,
                                'expanded' => true,
                                'attr' => array('class' => 'radioSuccess'),
                ))
            ->add('bibiStartDate', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                ))
            ->add('save', 'submit', array(
                                'attr' => array('class' => 'btn btn-lg btn-success mr5'),
                                'label' => 'Enregistrer'
                ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KSH\BibeBundle\Entity\Baby'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ksh_bibebundle_baby';
    }
}

<?php

namespace KSH\BibeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BiberonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baby', 'entity', array(
                        'class' => 'KSHBibeBundle:Baby',
                        'property' => 'psedo',
                        'multiple' => false
                ))
            ->add('date', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                ))
            ->add('waterVolume')//, 'number', array('empty_data' => 90))
            ->add('mesure')
            ->add('waterBrand', 'choice', array(
                                'choices' => array(
                                    'Mont Roucous' => 'Mont Roucous',
                                    'Hépar' => 'Hépar',
                                    'Evian' => 'Evian',     
                                ),
                                'multiple'  => false,
                                'label' => 'Type d\'eau'

                ))
            ->add('milkBrand', 'choice', array(
                                'choices' => array(
                                    'Gallia Calisma' => 'Gallia Calisma',
                                    'BabyBio' => 'BabyBio',
                                    'Guigoz' => 'Guigoz',
                                ),
                                'multiple'  => false,
                                'label' => 'Marque de lait'
                ))
            ->add('comment')
            ->add('save', 'submit', array(
                                'attr' => array('class' => 'btn btn-lg btn-success mr5'),
                                'label' => 'Valider'
                ))
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KSH\BibeBundle\Entity\Biberon'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ksh_bibebundle_biberon';
    }
}

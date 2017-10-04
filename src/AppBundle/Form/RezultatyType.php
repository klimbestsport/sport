<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RezultatyType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
              ->add('rezultatS1', TextType::class,array('required' => false))
                ->add('xS1', TextType::class,array('required' => false))
                ->add('rezultatS2', TextType::class,array('required' => false))
                ->add('xS2', TextType::class,array('required' => false))
                ->add('czas', TextType::class,array('required' => false))
                ->add('factor2', TextType::class,array('required' => false))
                ->add('uwagiS1', TextareaType::class, array('required' => false))
                ->add('uwagiS2', TextareaType::class, array('required' => false))
                ->add('imie', HiddenType::class)
                ->add('nazwisko', HiddenType::class)
                ->add('rokU', HiddenType::class)
                ->add('nrLic', HiddenType::class)
                ->add('klub', HiddenType::class)
                ->add('nazwa_s', HiddenType::class)
                ->add('nazwa_p', HiddenType::class)
                ->add('sumaRez', TextType::class, array('required' => false))
                ->add('pistolet', TextType::class, array('required' => false))
                ->add('karabin', TextType::class, array('required' => false))
                ->add('sumaX', TextType::class, array('required' => false));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rezultaty'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_rezultaty';
    }

}

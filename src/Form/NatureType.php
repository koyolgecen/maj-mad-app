<?php

namespace App\Form;

use App\Entity\CaracteristiqueNature;
use App\Entity\Marge;
use App\Entity\Nature;
use App\Entity\UniteNature;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NatureType extends AbstractType
{
    private const DATA_SIZE = 5;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomNature', TextType::class, [
                'label' => 'Nom de la nature'
            ])
            ->add('caracteristiqueNature', EntityType::class, [
                'label' => 'Caractéristique nature',
                'class' => CaracteristiqueNature::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'data-dropup-auto' => 'false'
                ]
            ])
            ->add('uniteNature', EntityType::class, [
                'label' => 'Unité nature',
                'class' => UniteNature::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'data-dropup-auto' => 'false'
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nature::class,
        ]);
    }
}

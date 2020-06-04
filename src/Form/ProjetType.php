<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\ModeleARealiser;
use App\Entity\Produit;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    private const DATA_SIZE = 5;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = [
            'class' => 'selectpicker show-tick',
            'data-live-search' => true,
            'data-size' => self::DATA_SIZE,
            'data-dropup-auto' => 'false'
        ];

        $builder
            ->add('type', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('reference', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'multiple' => 'multiple',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'title' => 'Choisir',
                    'data-dropup-auto' => 'false'
                ],
                'help' => 'Vous pouvez choisir plusieurs parmis les produits.'
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'placeholder' => 'Choisir',
                'required' => false,
                'attr' => $attr
            ])
            ->add('modeles', EntityType::class, [
                'class' => ModeleARealiser::class,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'multiple' => 'multiple',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'title' => 'Choisir',
                    'data-dropup-auto' => 'false'
                ],
                'help' => 'Vous pouvez choisir plusieurs parmis les modèles.'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}

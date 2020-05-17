<?php

namespace App\Form;

use App\Entity\Composant;
use App\Entity\FamilleComposant;
use App\Entity\Fournisseur;
use App\Entity\Marge;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposantType extends AbstractType
{
    private const DATA_SIZE = 5;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nature')
            ->add('quantite')
            ->add('prix')
            ->add('famille', EntityType::class, [
                'class' => FamilleComposant::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE
                ]
            ])
            ->add('marge', EntityType::class, [
                'class' => Marge::class,
                'placeholder' => 'Choisir',
                'required' => false,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE
                ]
            ])
            ->add('fournisseurs', EntityType::class, [
                'class' => Fournisseur::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'multiple' => 'multiple',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'title' => 'Choisir'
                ],
                'help' => 'Vous pouvez choisir plusieurs parmis les fournisseurs.'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Composant::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\CouvertureGamme;
use App\Entity\FinitionExterieurGamme;
use App\Entity\Gamme;
use App\Entity\IsolantGamme;
use App\Entity\ModeConception;
use App\Entity\QualiteHuisserieGamme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GammeType extends AbstractType
{
    private const DATA_SIZE = 5;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = [
            'class' => 'selectpicker show-tick',
            'data-live-search' => true,
            'data-size' => self::DATA_SIZE,
            'data-dropup-auto' => 'false'
        ];
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('isolant', EntityType::class, [
                'class' => IsolantGamme::class,
                'placeholder' => 'Choisir',
                'attr' => $attr
            ])
            ->add('couverture', EntityType::class, [
                'class' => CouvertureGamme::class,
                'placeholder' => 'Choisir',
                'attr' => $attr
            ])
            ->add('qualitehuisserie', EntityType::class, [
                'class' => QualiteHuisserieGamme::class,
                'placeholder' => 'Choisir',
                'attr' => $attr
            ])
            ->add('finitionExterieur', EntityType::class, [
                'class' => FinitionExterieurGamme::class,
                'placeholder' => 'Choisir',
                'attr' => $attr
            ])
            ->add('modeConception', EntityType::class, [
                'class' => ModeConception::class,
                'placeholder' => 'Choisir',
                'attr' => $attr,
                'required' => false
            ])
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gamme::class,
        ]);
    }
}

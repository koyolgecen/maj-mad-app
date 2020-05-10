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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('isolant', EntityType::class, [
                'class' => IsolantGamme::class,
                'placeholder' => 'Choisir'
            ])
            ->add('couverture', EntityType::class, [
                'class' => CouvertureGamme::class,
                'placeholder' => 'Choisir'
            ])
            ->add('qualitehuisserie', EntityType::class, [
                'class' => QualiteHuisserieGamme::class,
                'placeholder' => 'Choisir'
            ])
            ->add('finitionExterieur', EntityType::class, [
                'class' => FinitionExterieurGamme::class,
                'placeholder' => 'Choisir'
            ])
            ->add('modeConception', EntityType::class, [
                'class' => ModeConception::class,
                'placeholder' => 'Choisir'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gamme::class,
        ]);
    }
}

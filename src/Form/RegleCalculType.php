<?php

namespace App\Form;

use App\Entity\RegleCalcul;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegleCalculType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('calcul', NumberType::class, [
                'html5' => true,
                'scale' => 2,
                'attr' => [
                    'min' => 0.01,
                    'step' => 0.01,
                    'placeholder' => 0.01
                ],
                'help' => 'Mètre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegleCalcul::class,
        ]);
    }
}

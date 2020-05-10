<?php

namespace App\Form;

use App\Entity\ModeConception;
use App\Entity\RegleCalcul;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeConceptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('RegleCalcul', EntityType::class, [
                'class' => RegleCalcul::class,
                'placeholder' => 'Choisir'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModeConception::class,
        ]);
    }
}

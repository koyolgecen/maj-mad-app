<?php

namespace App\Form;

use App\Entity\CaracteristiqueNature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaracteristiqueNatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomCaracNature', TextType::class, [
                'label' => 'Nom caractéristique'
            ])
            ->add('descCaracNature', TextareaType::class, [
                'label' => 'Description caractéristique'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CaracteristiqueNature::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\CaracteristiqueNature;
use Symfony\Component\Form\AbstractType;
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
            ->add('descCaracNature', TextType::class, [
                'label' => 'Description caractéristique'
            ])
            ->add('natures')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CaracteristiqueNature::class,
        ]);
    }
}

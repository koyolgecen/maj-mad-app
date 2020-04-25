<?php

namespace App\Form;

use App\Entity\UniteNature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniteNatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descUniteNature', TextType::class, [
                'label' => 'Description unité'
            ])
            ->add('uniteUsageNature', TextType::class, [
                'label' => 'Unité usage'
            ])
            ->add('natures')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UniteNature::class,
        ]);
    }
}

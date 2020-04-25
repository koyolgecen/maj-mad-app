<?php

namespace App\Form;

use App\Entity\CaracteristiqueNature;
use App\Entity\Marge;
use App\Entity\Nature;
use App\Entity\UniteNature;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomNature')
            ->add('caracteristiquesNature', EntityType::class, [
                'class' => CaracteristiqueNature::class,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-custom'
                ]
            ])
            ->add('unitesNature', EntityType::class, [
                'class' => UniteNature::class,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-custom'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nature::class,
        ]);
    }
}

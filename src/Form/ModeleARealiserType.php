<?php

namespace App\Form;

use App\Entity\ModeleARealiser;
use App\Entity\ModuleARealiser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleARealiserType extends AbstractType
{
    private const DATA_SIZE = 5;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('modules', EntityType::class, [
                'class' => ModuleARealiser::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'multiple' => 'multiple',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'title' => 'Choisir',
                    'data-dropup-auto' => 'false'
                ],
                'help' => 'Vous pouvez choisir plusieurs parmis les modules.'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModeleARealiser::class,
        ]);
    }
}

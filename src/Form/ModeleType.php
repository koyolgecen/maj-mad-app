<?php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleType extends AbstractType
{
    private const DATA_SIZE = 5;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('modules',EntityType::class, [
                'label' => 'Modules',
                'class' => Module::class,
                'required' => true,
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
            'data_class' => Modele::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\ModeConception;
use App\Entity\RegleCalcul;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeConceptionType extends AbstractType
{
    private const DATA_SIZE = 5;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('RegleCalcul', EntityType::class, [
                'label' => 'Règle de calcul',
                'class' => RegleCalcul::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'data-dropup-auto' => 'false'
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModeConception::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\CCTP;
use App\Entity\Composant;
use App\Entity\CoupeDePrincipe;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    private const DATA_SIZE = 5;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité',
                'html5' => true,
                'attr' => [
                    'min' => 0,
                    'placeholder' => 1
                ]
            ])
            ->add('coupeDePrincipe',EntityType::class, [
                'class' => CoupeDePrincipe::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'data-dropup-auto' => 'false'
                ]
            ])
            ->add('cctp',EntityType::class, [
                'label' => 'CCTP',
                'class' => CCTP::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'data-dropup-auto' => 'false'
                ]
            ])
            ->add('moduleComposant',EntityType::class, [
                'label' => 'Composants',
                'class' => Composant::class,
                'required' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'multiple' => 'multiple',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'title' => 'Choisir',
                    'data-dropup-auto' => 'false'
                ],
                'help' => 'Vous pouvez choisir plusieurs parmis les composants.'
            ])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}

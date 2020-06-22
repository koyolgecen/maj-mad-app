<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\EtatDevis;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DevisType
 * @package App\Form
 */
class DevisType extends AbstractType
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
            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'placeholder' => 'Choisir',
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'data-dropup-auto' => 'false'
                ]
            ])
            ->add('etat', EntityType::class, [
                'class' => EtatDevis::class,
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}

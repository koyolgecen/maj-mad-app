<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\ModeleARealiser;
use App\Entity\Produit;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('dateCreation')
            ->add('reference')
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-custom'
                ]
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'placeholder' => 'Choisir',
                'required' => false
            ])
            ->add('modeles', EntityType::class, [
                'class' => ModeleARealiser::class,
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Choisir',
                'required' => false,
                'label_attr' => [
                    'class' => 'checkbox-custom'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}

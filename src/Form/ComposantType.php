<?php

namespace App\Form;

use App\Entity\Composant;
use App\Entity\FamilleComposant;
use App\Entity\Fournisseur;
use App\Entity\Marge;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nature')
            ->add('quantite')
            ->add('prix')
            ->add('famille', EntityType::class, [
                'class' => FamilleComposant::class
            ])
            ->add('marge', EntityType::class, [
                'class' => Marge::class,
                'placeholder' => 'Choisir'
            ])
            ->add('fournisseurs', EntityType::class, [
                'class' => Fournisseur::class,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Composant::class,
        ]);
    }
}

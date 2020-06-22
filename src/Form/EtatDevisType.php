<?php

namespace App\Form;

use App\Entity\EtatDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtatDevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('commendable', CheckboxType::class, [
                'help' => 'Cochez cette case si on pourrait commander le devis en cet état',
                'required' => false
            ])
            ->add('badgeStyle', ChoiceType::class, [
                'label' => 'Style du badge',
                'choices' => EtatDevis::BADGES,
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'badge badge-'. $choice];
                },
                'help' => 'Utilisé pour pouvoir afficher le statut avec du style dans le devis'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EtatDevis::class,
            'translation_domain' => false
        ]);
    }
}

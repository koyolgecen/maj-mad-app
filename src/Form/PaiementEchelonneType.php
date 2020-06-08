<?php

namespace App\Form;

use App\Entity\EtatDevis;
use App\Entity\PaiementEchelonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PaiementEchelonneType
 * @package App\Form
 */
class PaiementEchelonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nomEtape', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('pourcentageAPayer', PercentType::class, [
                'scale' => 2
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaiementEchelonne::class,
        ]);
    }
}

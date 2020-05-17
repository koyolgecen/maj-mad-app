<?php

namespace App\Form;

use App\Entity\Marge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('MargeEntreprise', PercentType::class, [
                'scale' => 2
            ])
            ->add('MargeCommerciale', PercentType::class, [
                'scale' => 2
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Marge::class,
        ]);
    }
}

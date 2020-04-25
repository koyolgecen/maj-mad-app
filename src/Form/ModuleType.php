<?php

namespace App\Form;

use App\Entity\CCTP;
use App\Entity\Composant;
use App\Entity\CoupeDePrincipe;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('quantite')
            ->add('coupeDePrincipe_id',EntityType::class, [
                'class' => CoupeDePrincipe::class,
                'placeholder' => 'Choisir'
            ])
            ->add('cctp_id',EntityType::class, [
                'class' => CCTP::class,
                'placeholder' => 'Choisir'
            ])
            ->add('moduleComposant',EntityType::class, [
                'class' => Composant::class,
                'placeholder' => 'Choisir',
                'multiple' => true,
                'expanded' => true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}

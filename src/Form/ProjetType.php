<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    private $projetRepo;

    /**
     * ProjetType constructor.
     * @param ProjetRepository $projetRepo
     */
    public function __construct(ProjetRepository $projetRepo)
    {
        $this->projetRepo = $projetRepo;
    }

    private const DATA_SIZE = 5;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $projets = $this->projetRepo->findBy([], ['id' => 'desc']);
        if (count($projets)) {
            $id = end($projets)->getId() + 1;
        } else {
            $id = 1;
        }
        $attr = [
            'class' => 'selectpicker show-tick',
            'data-live-search' => true,
            'data-size' => self::DATA_SIZE,
            'data-dropup-auto' => 'false'
        ];

        $builder
            ->add('type', TextType::class, [
                'attr' => [
                    'placeholder' => 'Saisir'
                ]
            ])
            ->add('reference', TextType::class, [
                'data' => '#' . $id,
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ])
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'multiple' => 'multiple',
                    'data-live-search' => true,
                    'data-size' => self::DATA_SIZE,
                    'title' => 'Choisir',
                    'data-dropup-auto' => 'false'
                ],
                'help' => 'Vous pouvez choisir plusieurs parmis les produits.'
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'placeholder' => 'Choisir',
                'required' => false,
                'attr' => $attr
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

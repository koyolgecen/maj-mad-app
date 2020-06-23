<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\EtatDevis;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DevisType
 * @package App\Form
 */
class DevisType extends AbstractType
{
    private const DATA_SIZE = 5;

    /** @var TranslatorInterface */
    private $translator;

    /**
     * DevisType constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $etatsChoices = [];
        foreach (Devis::ETATS as $etat) {
            if ($etat === Devis::ETAT_EN_COMMANDE or $etat === Devis::ETAT_TRANSFERT_EN_FACTURATION) {
                continue;
            }
            $label = $this->translator->trans('etat.'.strtolower($etat), [], 'devis');
            $etatsChoices[$label] = $etat;
        }
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
            ->add('etat', ChoiceType::class, [
                'choices' => $etatsChoices,
                'attr' => [
                    'class' => 'selectpicker show-tick',
                    'data-live-search' => true,
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

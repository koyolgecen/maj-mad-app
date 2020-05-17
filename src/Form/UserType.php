<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $options['user'];
        $modif = $options['modification'];
        $builder
            ->add('nom')
            ->add('prenom', TextType::class, [
                'label' => 'prenom'
            ])
            ->add('login', TextType::class, [
                'help' => 'login.help'
            ])
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => $modif ? 'motdepasse.new' : 'motdepasse.default'
                ],
                'second_options' => [
                    'label' => 'motdepasse.repeter'
                ],
                'invalid_message' => 'motdepasse.identiques',
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'motdepasse.minMessage',
                        'maxMessage' => 'motdepasse.maxMessage'
                    ])
                ],
                'required' => !$modif
            ])
        ;
        // on peut manipuler les rôles uniquement si on est admin
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => User::ROLES_WITH_LABEL_FR,
                'label' => 'roles',
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-custom checkbox-inline'
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null,
            'modification' => null,
            'translation_domain' => 'utilisateur'
        ]);
    }
}

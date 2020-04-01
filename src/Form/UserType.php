<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $options['user'];
        $builder
            ->add('nom')
            ->add('prenom', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('login', TextType::class, [
                'help' => 'Utilisé pour pouvoir connecter à l\'application.'
            ])
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Mot de passe obligatoire!'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'Allez, vous pouvez penser à un mot de passe plus long que ça!',
                        'maxMessage' => 'Mot de passe est très long!'
                    ])
                ]
            ])
        ;

        // on peut manipuler les rôles uniquement si on est admin
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'Commercial' => 'ROLE_COMMERCIAL',
                    'Bureau d\'étude' => 'ROLE_BUREAU_DETUDE',
                    'Admin' => 'ROLE_ADMIN'
                ],
                'label' => 'Rôles',
                'multiple' => true
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'user' => null
        ]);
    }
}

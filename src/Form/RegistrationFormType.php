<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Votre prénom',
            'constraints' => new Length([
                'min' => 3,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'merci de saisir votre prénom'
            ],
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Votre nom',
            'attr' => [
                'placeholder' => 'merci de saisir votre nom'
            ],
        ])
        ->add('phone', TextType::class, [
            'label' => 'Votre numéro',
            'constraints' => new Length([
                'min' => 3,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'merci de saisir votre numéro de téléphone'
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Votre email',
            'constraints' => new Length([
            'min' => 3,
            'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'merci de saisir votre adresse email'
            ],
        ])
            ->add('userType', ChoiceType::class, [
                'choices' => [
                    'Entreprise' => 'ROLE_ENTREPRISE',
                    'Candidat' => 'ROLE_CANDIDAT',
                ],
                'expanded' => true,
                'multiple' => false,
                'mapped' => false,
                'label' => 'Choisissez votre type de compte',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez selectionner votre type de compte.',
                        ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les conditions',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci d\'accepter les termes',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'label' => 'Votre mot de passe',
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique.',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Merci de saisir votre mot de passe.'
                        ]
                ],
                'second_options' => [
                        'label' => 'Confirmez votre mot de passe',
                        'attr' => ['placeholder' => 'Merci de confirmer votre mot de passe.'
                            ]
                ],
                'attr' => ['placeholder' => 'Merci de saisir un mot de passe'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

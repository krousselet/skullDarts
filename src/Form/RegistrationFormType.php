<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email : ',
                'attr' => [
                    'placeholder' => 'Renseignez une adresse email...'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Renseignez votre nom...'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom :',
                'attr' => [
                    'placeholder' => 'Renseignez votre prenom...'
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone :',
                'attr' => [
                    'placeholder' => 'Renseignez un numéro de telephone...'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les termes',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions d\'utilisation',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, options: [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les deux champs doivent correspondre',
                'required' => true,
                'options' => [
                    'attr' => [
                        'class' => 'password-field',
                        'autocomplete' => 'new-password',
                    ]
                ],
                'first_options'  => [
                    'label' => 'Mot de passe : ',
                    'attr' => [
                        'placeholder' => 'Renseignez votre mot de passe...'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le champs ne peut pas être vide...',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options'  => [
                    'label' => 'Verification : ',
                    'attr' => [
                        'placeholder' => 'Faites correspondre votre mot de passe...'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le champs ne peut pas être vide...',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

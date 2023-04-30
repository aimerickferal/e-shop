<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PPRE_SET_DATA to modify the form depending on the pre-populated data.
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            ->add('picture', HiddenType::class, [])
            ->add('civilityTitle', ChoiceType::class, [
                'choices' => [
                    'Monsieur' => User::MAN_CIVILITY_TITLE,
                    'Madame' => User::WOMAN_CIVILITY_TITLE,
                ],
                'choice_attr' => [
                    'Monsieur' => [
                        'class' => 'form-field__user-civility-title-input form-field__user-civility-title-man-input',
                    ],
                    'Madame' => [
                        'class' => 'form-field__user-civility-title-input form-field__user-civility-title-woman-input',
                    ],
                ],
                'data' =>  User::MAN_CIVILITY_TITLE,
                'expanded' => true,
            ])
            ->add('firstName', null, [
                'empty_data' => ''
            ])
            ->add('lastName', null, [
                'empty_data' => ''
            ])
            ->add('email', EmailType::class, [
                'empty_data' => ''
            ])
            ->add('password', HiddenType::class, [])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => User::ROLE_ADMIN
                ],
                'choice_attr' => [
                    'Administrateur' => [
                        'class' => 'form-field__user-roles-input form-field__user-roles-admin-input'
                    ]
                ],
                'expanded' => true,
                'multiple' => true
            ]);
    }

    /**
     * Method that modify the form and display somes fields only if we are in case of user creation so we don't dislay the password field on user update.
     * @param FormEvent $event
     * @return void
     */
    public function onPreSetData(FormEvent $event)
    {
        // We get the form. 
        $form = $event->getForm();

        // We get the data of the user.
        $user = $event->getData();

        // If we don't find any user in the database. This mean we are in creation mode. 
        if (!$user->getId()) {
            // We dynamically add the fields that will be required for the creation form.
            $form
                ->add('picture', FileType::class, [
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '300k',
                            'maxSizeMessage' => 'Merci de télécharger un fichier de maximum {{ limit }} bytes.',
                            'mimeTypes' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.',
                        ])
                    ]
                ])
                ->add('password', PasswordType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir un mot de passe.',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex([
                            // Regex that match only value that contain at least 1 lowercase alphabetical character.
                            'pattern' => '/(?=.*[a-z])/',
                            'message' => 'Le mot de passe doit contenir au moins une minuscule.'
                        ]),
                        new Regex([
                            // Regex that match only value that contain at least 1 uppercase alphabetical character.
                            'pattern' => '/(?=.*[A-Z])/',
                            'message' => 'Le mot de passe doit contenir au moins une majuscule.'
                        ]),
                        new Regex([
                            // Regex that match only value that contain at least 1 numeric character.
                            'pattern' => '/(?=.*[0-9])/',
                            'message' => 'Le mot de passe doit contenir au moins un chiffre.'
                        ]),
                        new Regex([
                            // Regex that match only value that contain at least 1 one special character, but we are escaping reserved RegEx characters to avoid conflict.
                            'pattern' => '/(?=.*[!@#$%^&*])/',
                            new Regex([
                                'pattern' => '/(?=.*[!@#$%^&*])/',
                                'message' => 'Le mot de passe doit contenir au moins un caractére spécial.'
                            ])
                        ])
                    ]
                ]);
        }
        // Else we find a user in the database. This mean we are in update mode.
        else {
            // We dynamically add the fields that will be required for the update form.
            $form
                ->add('civilityTitle', ChoiceType::class, [
                    'choices' => [
                        User::MAN_CIVILITY_TITLE => User::MAN_CIVILITY_TITLE,
                        User::WOMAN_CIVILITY_TITLE => User::WOMAN_CIVILITY_TITLE
                    ],
                    'choice_attr' => [
                        User::MAN_CIVILITY_TITLE => [
                            'class' => 'form-field__user-civility-title-input form-field__user-civility-title-man-input',
                        ],
                        User::WOMAN_CIVILITY_TITLE => [
                            'class' => 'form-field__user-civility-title-input form-field__user-civility-title-woman-input',
                        ],
                    ],
                    'expanded' => true,
                ])
                ->add('upload', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '300k',
                            'maxSizeMessage' => 'Merci de télécharger un fichier de maximum {{ limit }} bytes.',
                            'mimeTypes' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.',
                        ])
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Erreur dans la saisie de ma commande' => 'Erreur dans la saisie de ma commande',
                    'Retard de livraison & SAV' => 'Retard de livraison & SAV',
                    'Problème informatique' => 'Problème informatique'
                ],
                'data' =>   'Monsieur',
                'choice_attr' => [
                    'Erreur dans la saisie de ma commande' => [
                        'class' => 'form-field__contact-subject-input',
                    ],
                    'Retard de livraison & SAV' => [
                        'class' => 'form-field__contact-subject-input',
                    ],
                    'Problème informatique' => [
                        'class' => 'form-field__contact-subject-input',
                    ]
                ],
                'expanded' => true,
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Merci de sélectionner un sujet.',
                    ]),
                ],
            ])
            ->add('civilityTitle', ChoiceType::class, [
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame'
                ],
                'data' =>   'Monsieur',
                'choice_attr' => [
                    'Monsieur' => [
                        'class' => 'form-field__user-civility-title-input form-field__user-civility-title-man-input',
                    ],
                    'Madame' => [
                        'class' => 'form-field__user-civility-title-input form-field__user-civility-title-woman-input',
                    ],
                ],
                'expanded' => true,
            ])
            ->add('firstName', null, [
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Merci de saisir un prénom.'
                    ]),
                ]
            ])
            ->add('lastName', null, [
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Merci de saisir un nom.'
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Merci de saisir un e-mail.'
                    ]),
                    new Regex([
                        'pattern' => '/^(.+)@(\S+)$/',
                        'message' => 'Merci de saisir un e-mail valide.'
                    ])
                ]
            ])
            ->add('phoneNumber', null, [
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Merci de saisir un numéro de téléphone mobile.'
                    ]),
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Merci de saisir un numéro de téléphone mobile.'
                    ]),
                    new Regex([
                        'pattern' => '/^((06)|(07))[0-9]{8}$/',
                        'message' => 'Merci de saisir un numéro de téléphone mobile.'
                    ]),
                ]
            ])
            ->add('upload', FileType::class, [
                "required" => false,
                'constraints' => [
                    new File([
                        'maxSize' => '300k',
                        'maxSizeMessage' => 'Merci de téléverser un fichier de maximum {{ limit }} bytes.',
                        'mimeTypes' => [
                            'application/pdf',
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de téléverser un fichier au format PDF, PNG, JPEG ou SVG.',
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Merci de saisir un message.'
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

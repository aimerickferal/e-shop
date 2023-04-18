<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PRE_SUBMIT to check the data of some fields, before submitting the data to the form.
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->add('civilityTitle', ChoiceType::class, [
                'choices' => [
                    User::MAN_CIVILITY_TITLE => User::MAN_CIVILITY_TITLE,
                    User::WOMAN_CIVILITY_TITLE => User::WOMAN_CIVILITY_TITLE
                ],
                'choice_attr' => [
                    User::MAN_CIVILITY_TITLE => [
                        'class' => 'form-field__user-civility-title-input form-field__user-civility-title-man-input form-field__user-civility-title-profile-input',
                    ],
                    User::WOMAN_CIVILITY_TITLE => [
                        'class' => 'form-field__user-civility-title-input form-field__user-civility-title-woman-input form-field__user-civility-title-profile-input',
                    ],
                ],
                'expanded' => true,
                'disabled'  => true,
            ])
            ->add('picture', HiddenType::class, [])
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
            ])
            ->add('firstName', null, [
                'empty_data' => ''
            ])
            ->add('lastName', null, [
                'empty_data' => ''
            ])
            ->add('email', EmailType::class, [
                'empty_data' => ''
            ]);
    }


    /**
     * Method that change the data of the civility title property according to the user input. 
     * @param FormEvent
     * @return void
     */
    public function onPreSubmit(FormEvent $event)
    {
        // We get the form. 
        $form = $event->getForm();

        // We get the data of the user.
        $user = $event->getData();

        // TODO #2 START : solve issue on switch civilityTitle. 
        // dump($user);
        // dd($user['civilityTitle']);

        // We set to the civility title property the value input by the user. 
        $form
            ->add('civilityTitle', ChoiceType::class, [
                'choices' => [
                    User::MAN_CIVILITY_TITLE => User::MAN_CIVILITY_TITLE,
                    User::WOMAN_CIVILITY_TITLE => User::WOMAN_CIVILITY_TITLE
                ],
                'data' => $user['civilityTitle'],
                'expanded' => true,
            ]);
        // TODO #2 END : solve issue on switch civilityTitle.  

        // We set the data of the event with the new data of the user.
        $event->setData($user);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

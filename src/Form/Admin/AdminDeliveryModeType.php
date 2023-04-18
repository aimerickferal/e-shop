<?php

namespace App\Form\Admin;

use App\Entity\DeliveryMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminDeliveryModeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PPRE_SET_DATA to modify the form depending on the pre-populated data.
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            ->add('picture', HiddenType::class, [])
            ->add('name', null, [
                'empty_data' => ''
            ])
            ->add('price', MoneyType::class, [
                'empty_data' => '',
                'currency' => false,
                'divisor' => 100
            ])
            ->add('minCartAmountForFreeDelivery', MoneyType::class, [
                'empty_data' => '',
                'currency' => false,
                'divisor' => 100
            ])
            ->add('description', TextareaType::class, []);
    }


    /**
     * Method that modify the form and display the picture field in case of delivery mode creation and the upload field in case of delivery mode update. 
     * @param FormEvent $event
     * @return void
     */
    public function onPreSetData(FormEvent $event)
    {
        // We get the form. 
        $form = $event->getForm();

        // We get the data of the delivery mode.
        $deliveryMode = $event->getData();

        // If we don't find any delivery mode in the database. This mean we are in creation mode. 
        if (!$deliveryMode->getId()) {
            $form
                ->add('picture', FileType::class, [
                    "required" => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.'
                        ]),
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
        // Else we find a delivery mode in the database. This mean we are in update mode.
        else {
            // We dynamically add the fields that will be required for the update form.
            $form
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
            'data_class' => DeliveryMode::class,
        ]);
    }
}

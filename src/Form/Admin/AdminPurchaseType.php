<?php

namespace App\Form\Admin;

use App\Entity\Address;
use App\Entity\DeliveryMode;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use App\Twig\AmountExtension;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminPurchaseType extends AbstractType
{
    public function __construct(private PurchaseRepository $purchaseRepository, private AmountExtension $amountExtension)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PPRE_SET_DATA to modify the form depending on the pre-populated data.
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            // We use the addEventlistener method on PRE_SUBMIT to check the data of some fields, before submitting the data to the form.
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    Purchase::STATUS_PAID => Purchase::STATUS_PAID,
                    Purchase::STATUS_IN_PROGRESS => Purchase::STATUS_IN_PROGRESS,
                    Purchase::STATUS_SEND => Purchase::STATUS_SEND,
                    Purchase::STATUS_DELIVER => Purchase::STATUS_DELIVER,
                    Purchase::STATUS_ANNUL => Purchase::STATUS_ANNUL
                ],
                'choice_attr' => [
                    Purchase::STATUS_PAID => [
                        'class' => 'form-field__purchase-status-input form-field__purchase-status-paid-input'
                    ],
                    Purchase::STATUS_IN_PROGRESS => [
                        'class' => 'form-field__purchase-status-input form-field__purchase-status-in-progress-input'
                    ],
                    Purchase::STATUS_SEND => [
                        'class' => 'form-field__purchase-status-input form-field__purchase-status-send-input'
                    ],
                    Purchase::STATUS_DELIVER => [
                        'class' => 'form-field__purchase-status-input form-field__purchase-status-deliver-input'
                    ],
                    Purchase::STATUS_ANNUL => [
                        'class' => 'form-field__purchase-status-input form-field__purchase-status-annul-input'
                    ]
                ],
                'expanded' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de sélectionner un statut.'
                    ])
                ]
            ])
            ->add('billingAddress', HiddenType::class, [])
            ->add('deliveryAddress', HiddenType::class, [])
            ->add('deliveryMode', HiddenType::class, [])
            ->add('reference', HiddenType::class, [])
            ->add('bill', HiddenType::class, []);
    }

    /**
     * Method that diplay the form fields dynamically according to the fact that we are in case of creation or in case of update. 
     * @param FormEvent $formEvent
     * @return void
     */
    public function onPreSetData(FormEvent $formEvent)
    {
        // We get the form.
        $form = $formEvent->getForm();

        // We get the data of the purchase.
        $purchase = $formEvent->getData();

        // We create a empty array to backup each address.
        $addresses = [];

        foreach ($purchase->getUser()->getAddresses() as $address) {
            // We push each address in the array.
            $addresses[] = $address;
        }

        // If we don't find any purchase in the database. This mean we are in creation mode.
        if (!$purchase->getId()) {
            // We dynamically add the fields that will be required for the creation form.
            $form
                ->add(
                    'billingAddress',
                    ChoiceType::class,
                    [
                        'choices' => $addresses,
                        'choice_attr' => function (Address $address, $key, $index) {
                            return ['class' => 'form-field__purchase-billing-address-input'];
                        },
                        // 'choice_value' => function (Address $address) {
                        //     return
                        //         $address->getFirstName() . ' ' . $address->getLastName() . ' ' . $address->getStreetNumber() . ' ' . $address->getStreetName() . ' ' . $address->getZipCode() . ' ' . $address->getCity() . ' ' . $address->getCountry() . ' ' . $address->getPhoneNumber();
                        // },
                        'choice_label' => function (Address $address) {
                            return
                                $address->getFirstName() . ' ' . $address->getLastName() . ' [br]' . $address->getStreetNumber() . ' ' . $address->getStreetName() . ' [br]' . $address->getZipCode() . ' - ' . $address->getCity() . ' [br]' . $address->getCountry() . ' [br]' . $address->getPhoneNumber();
                        },
                        'data' => $addresses[0] ?? null,
                        'expanded'      => true
                    ]
                )
                ->add(
                    'deliveryAddress',
                    ChoiceType::class,
                    [
                        'choices' => $addresses,
                        'choice_attr' => function (Address $address, $key, $index) {
                            return ['class' => 'form-field__purchase-delivery-address-input'];
                        },
                        'choice_label' => function (Address $address) {
                            return
                                $address->getFirstName() . ' ' . $address->getLastName() . ' [br]' . $address->getStreetNumber() . ' ' . $address->getStreetName() . ' [br]' . $address->getZipCode() . ' - ' . $address->getCity() . ' [br]' . $address->getCountry() . ' [br]' . $address->getPhoneNumber();
                        },
                        'data' => $addresses[0] ?? null,
                        'expanded'      => true
                    ]
                )
                ->add('deliveryMode', EntityType::class, [
                    'class' => DeliveryMode::class,
                    'choice_attr' => function (DeliveryMode $deliveryMode, $key, $index) {
                        return ['class' => 'form-field__purchase-delivery-mode-input'];
                    },
                    'choice_label' => function (DeliveryMode $deliveryMode) {
                        return $deliveryMode->getName() . ' à ' . $this->amountExtension->amount($deliveryMode->getPrice()) . '. ' . $deliveryMode->getDescription() . ' Gratuit si commande interne.';
                    },
                    'expanded'      => true
                ])
                ->add('bill', FileType::class, [
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.'
                        ]),
                        new File([
                            'maxSize' => '2000k',
                            'maxSizeMessage' => 'Merci de télécharger un fichier de maximum {{ limit }} bytes.',
                            'mimeTypes' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.'
                        ])
                    ]
                ]);
        }
        // Else we find a purchase in the database. This mean we are in update mode.
        else {
            // We dynamically add the fields that will be required for the update form.
            $form
                ->add('upload', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2000k',
                            'maxSizeMessage' => 'Merci de télécharger un fichier de maximum {{ limit }} bytes.',
                            'mimeTypes' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'image/svg+xml'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger un fichier au format PDF, PNG, JPEG ou SVG.'
                        ])
                    ]
                ]);
        }
    }

    /**
     * Method that create a unique reference for the purchase.
     * @param FormEvent $formEvent
     * @return void
     */
    public function onPreSubmit(FormEvent $formEvent)
    {
        // We get the form.
        $form = $formEvent->getForm();

        // We get the data of the purchase.
        $purchase = $formEvent->getData();

        // If the submit doesn't contain a purchase with a reference.
        if (!$purchase['reference']) {
            // We set the reference property.
            $purchase['reference'] = bin2hex(random_bytes(6));
        }

        // We set the data of the form event with the new data of the product.
        $formEvent->setData($purchase);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class
        ]);
    }
}

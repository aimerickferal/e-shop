<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\DeliveryMode;
use App\Entity\Purchase;
use App\Twig\AmountExtension;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class PurchaseType extends AbstractType
{
    public function __construct(private AmountExtension $amountExtension)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // We use the addEventlistener method on PPRE_SET_DATA to modify the form depending on the pre-populated data.
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData'])
            // We use the addEventlistener method on PRE_SUBMIT to check the data of some fields, before submitting the data to the form.
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->add('billingAddress', HiddenType::class, [])
            ->add('deliveryAddress', HiddenType::class, [])
            ->add('deliveryMode', EntityType::class, [
                'class' => DeliveryMode::class,
                'choice_attr' => function (DeliveryMode $deliveryMode, $key, $index) {
                    return [
                        'class' => 'form-field__purchase-delivery-mode-input',
                        'data-deliverymodeprice' => $deliveryMode->getPrice(),
                        'data-deliverymodeamount' => $this->amountExtension->amount($deliveryMode->getPrice()),
                        'data-mincartamountforfreedelivery' => $deliveryMode->getMinCartAmountForFreeDelivery()
                    ];
                },
                'choice_label' => function (DeliveryMode $deliveryMode) {
                    return $deliveryMode->getName() . ' à ' . $this->amountExtension->amount($deliveryMode->getPrice()) . '. ' . $deliveryMode->getDescription();
                },
                'expanded'      => true
            ])
            ->add('checkoutMethod', ChoiceType::class, [
                'choices' => [
                    Purchase::CHECKOUT_METHOD_CARD_WITH_STRIPE => Purchase::CHECKOUT_METHOD_CARD_WITH_STRIPE,
                    Purchase::CHECKOUT_METHOD_PAYPAL => Purchase::CHECKOUT_METHOD_PAYPAL
                ],
                'choice_attr' => [
                    Purchase::CHECKOUT_METHOD_CARD_WITH_STRIPE => [
                        'class' => 'form-field__purchase-checkout-method-input form-field__stripe-input',
                        'data-value' => Purchase::CHECKOUT_METHOD_CARD_WITH_STRIPE

                    ],
                    Purchase::CHECKOUT_METHOD_PAYPAL => [
                        'class' => 'form-field__purchase-checkout-method-input form-field__paypal-input',
                        'data-value' => Purchase::CHECKOUT_METHOD_PAYPAL
                    ]
                ],
                'data' =>  null,
                'expanded' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de sélectionner un moyen de paiement.'
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci de confirmer avoir lu et accepter nos Conditions Générales de Vente.'
                    ])
                ]
            ])
            ->add('bill', HiddenType::class, [])
            ->add('status', HiddenType::class, [])
            ->add('reference', HiddenType::class, []);
    }

    /**
     * Method that get the addresses of the logged in user before the form display. 
     * @param FormEvent $formEvent
     * @return void
     */
    public function onPreSetData(FormEvent $formEvent)
    {
        // We get the form. 
        $form = $formEvent->getForm();

        // We get the data of the purchase.
        $purchase = $formEvent->getData();

        // We create a array to backup each address of the logged in user. 
        $addresses = [];

        foreach ($purchase->getUser()->getAddresses() as $address) {
            // We push each address in the array.
            $addresses[] = $address;
        }

        $form
            ->add(
                'billingAddress',
                ChoiceType::class,
                [
                    'choices' => $addresses,
                    'choice_attr' => function (Address $address, $key, $index) {
                        return ['class' => 'form-field__purchase-billing-address-input'];
                    },
                    'choice_label' => function (Address $address) {
                        return
                            $address->getFirstName() . ' ' . $address->getLastName() . ' [br]' . $address->getStreetNumber() . ' ' . $address->getStreetName() . ' [br]' . $address->getZipCode() . ' - ' . $address->getCity() . ' [br]' . $address->getCountry() . ' [br]' . $address->getPhoneNumber();
                    },
                    'data' => $addresses[0],
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
                    'data' => $addresses[0],
                    'expanded'      => true
                ]
            );
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
            // We set the reference property of the purchase.
            $purchase['reference'] = bin2hex(random_bytes(6));
            // We set the status of the purchase.
            $purchase['status'] = Purchase::STATUS_PENDING;
            // We set the bill of the purchase.
            $purchase['bill'] = Purchase::BILL_BY_DEFAULT;
        }

        // We set the data of the event with the new data of the purchase.
        $formEvent->setData($purchase);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class
        ]);
    }
}

<?php

namespace App\Service\Checkout;

use App\Entity\Purchase;
use App\Service\Cart\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeCheckout
{
    public function __construct(readonly private string $stripeSecretKey, private UrlGeneratorInterface $urlGeneratorInterface, private EntityManagerInterface $entityManagerInterface)
    {
        Stripe::setApiKey($this->stripeSecretKey);
        // We specify the API version that its used by the app.
        Stripe::setApiVersion('2020-08-27');
    }

    /**
     * @param Cart $cart
     * @param Purchase $purchase
     * @param int $deliveryModePrice
     * @param string $deliveryModeDescription
     * @return string
     */
    public function startStripeCheckout(Cart $cart, Purchase $purchase, int $deliveryModePrice, string $deliveryModeDescription)
    {
        // dd("StripeCheckout : startStripeCheckout()");

        // We create a Stripe session.
        $session = Session::create([
            'mode' => 'payment',
            // We set the sucess URL in order to redirect the user in the case of a successful checkout.
            'success_url' => $this->urlGeneratorInterface->generate(
                'purchase_stripe_success',
                [
                    // We set a array of optional data.
                    'reference' => $purchase->getReference()
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            // We set the cancel URL in order to redirect the user in the case of cancel checkout.
            'cancel_url' => $this->urlGeneratorInterface->generate(
                'cart_detail',
                // We set a array of optional data.
                [],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'line_items' => [
                array_map(fn ($product) => [
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            // We return the name of each CartItem().
                            'name' => $product->getName(),
                        ],
                        // We return the Price of each CartItem().
                        'unit_amount' => $product->getPrice(),
                    ],
                    // We return the quantity of each CartItem().
                    'quantity' => $product->getQuantity(),
                ], $cart->getItems())
            ],
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => $deliveryModePrice,
                            'currency' => 'eur',
                        ],
                        // The name of the shipping rate display to the customer will be the description of the chosen delivery mode.
                        'display_name' => $deliveryModeDescription,
                    ]
                ],
            ],
            'metadata' => [
                // We return the cart id.
                'cart_id' => $cart->getId()
            ]
        ]);

        // We return the URL generate by Stripe to make the checkout on their interface. 
        return $session;

        // If checkout is accepted : OK. 

        // If the user backup : the user is redirect to the cancel_url and the purchase is remove from the database. Other option will be to use START : purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT. 

        // If the checkout is decline because of insufficient funds : the user is redirect to the cancel_url and the purchase is remove from the database. Other option is to use : START : purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT and take back the started purchase insted of create a new one.
    }
}

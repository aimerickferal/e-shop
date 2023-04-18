<?php

namespace App\Service\Checkout;

use App\Service\Cart\Cart;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
// use Psr\Http\Message\ServerRequesInterface;
use Symfony\Component\HttpFoundation\Request;

class PaypalCheckout
{
    public function __construct(private Cart $cart)
    {
    }

    /**
     * Method that return the HTML who represent the user interface and the JS for the process.
     * @return string
     */
    public function showUserInterface(): string
    {
        // TODO #3 START : Make Paypal checkout.
        // 6fcf417f36eA@0581f69
        // ETzID^t3

        dd("PaypalCheckout : showUserInterface()");

        // The client id is backup in the environnement variable PAYPAL_CLIENT_ID.
        $paypalClientId = $_ENV['PAYPAL_CLIENT_ID'];
        // $total = ($this->cart->getTotal() / 100) + $deliveryModePrice;

        // We create our purchase.
        // We use the PHP method json_encode() to transform the PHP array in JSON.
        $purchase = json_encode([
            'purchase_units' => [
                [
                    'description' => 'Panier : e-shop',
                    'items' => array_map(function ($product) {
                        return [
                            // We return the name of each CartItem().
                            'name' => $product->getName(),
                            // We return the quantity of each CartItem().
                            'quantity' => $product->getQuantity(),
                            'unit_amount' => [
                                // We return the Price of each CartItem().
                                'value' => $product->getPrice() / 100,
                                'currency_code' => 'EUR'
                            ]
                        ];
                    }, $this->cart->getItems()),
                    'amount' => [
                        'value' => $this->cart->getTotal() / 100,
                        'currency_code' => 'EUR',
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'EUR',
                                'value' => $this->cart->getTotal() / 100
                            ]
                        ]
                    ]
                ],
                // 'shipping' => [
                //     'options' => [
                //         'id' => "1",
                //         'label' => "Free SOSA",
                //         'type' => "Shipping",
                //         'selected' => true,
                //         'amount' => [
                //             'value' => "1",
                //             'currency_code' => 'EUR'
                //         ]
                //     ]
                // ]
            ]
        ]);
        // dd($purchase);

        return <<<HTML
        <script src="https://www.paypal.com/sdk/js?client-id={$paypalClientId}&currency=EUR&intent=authorize"></script>
        <!-- Set up a container element for the button -->
        <div class="paypal-button-container" id="paypal-button-container"></div>
        <script>
            paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({$purchase});
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                actions.order.authorize().then(function(authorization) {
                    console.log(authorization, data);
                    const authorizationId = authorization.purchase_units[0].payments.authorizations[0].id
                    console.log(authorizationId);
                })
            }
        }).render('#paypal-button-container');
        </script>
        HTML;
    }


    /**
     * Method that ...
     * @return void
     */
    public function handle(Request $request): void
    {
        // If this is true to say that we are in a sandbox environement.
        if ($this->isSandbox) {
            // We create our sandbox environnement.
            $environnement = new SandboxEnvironment($this->paypalClientId, $this->paypalClientSecret);
        }
        // Else we are in production environnement.
        else {
            // We create our production environnement.
            $environnement = new SandboxEnvironment($this->paypalClientId, $this->paypalClientSecret);
        }

        // We give the environnement to the client.
        $client = new \PaypalCheckoutSdk\Core\PaypalHttpClient($environnement);
        // We get the authorizationId in the request.
        $authorizationId = $request->query->get('authorizationId');
        // We create the request with the authorizationId.
        $request = new \PaypalCheckoutSdk\Payments\AuthorizationGetRequest($authorizationId);
        // We execute the request.
        $authorizationResponse = $client->execute($request);
        // dd($authorizationResponse);
        // We get the amount of the purchase.
        // We use the PHP method floatval() to get only the float value.
        // We use the PHP method round() to round this value.
        // We type int the value with (int) to convert the data to a integer.
        $amount = (int)round(floatval($authorizationResponse->result->amount->value) * 100);

        // If the amount of the purchase is different than the price total of the cart.
        if ($amount !== $this->cart->getTotal()) {
            // TODO trow new exception.
        }

        // Check the products availability in the stock.
        // Lock the stock, remove the prodcts form the stock.
        // Backup the user data.

        // We catch the payment.

        // We create a new request with the authorizationId.
        $request = new AuthozationsCaptureRequest($authorizationId);
        // We execute the request.
        $response = $client->execute($request);

        // If the response is not completed.
        if ($response->result->status !== 'COMPLETED') {
            // TODO trow new exception.
        }

        dd($response);
    }
    // TODO #3 END : Paypal checkout

}

<?php

namespace App\Controller;

use App\Entity\DeliveryMode;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\PurchaseSearch;
use App\Entity\User;
use App\Form\PurchaseType;
use App\Form\PurchaseSearchType;
use App\Repository\DeliveryModeRepository;
use App\Repository\PurchaseRepository;
use App\Service\Cart\Cart;
use App\Service\Checkout\PaypalCheckout;
use App\Service\Checkout\StripeCheckout;
use App\Service\Email;
use App\Service\PurchaseAddress;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[IsGranted('ROLE_USER')]
class PurchaseController extends AbstractController
{
    public function __construct(private PurchaseRepository $purchaseRepository, private Cart $cart, private PurchaseAddress $purchaseAddress, private EntityManagerInterface $entityManagerInterface)
    {
    }

    /**
     * Methot that display the purchase page.
     * @param Request $request
     * @param DeliveryModeRepository $deliveryModeRepository
     * @param UrlGeneratorInterface $urlGeneratorInterface
     * @return Response
     */
    #[Route('/commande', name: 'purchase', methods: 'GET|POST')]
    public function purchase(Request $request, DeliveryModeRepository $deliveryModeRepository, UrlGeneratorInterface $urlGeneratorInterface): Response
    {
        // We get all the CartItems that exist in the cart.
        $cartItems = $this->cart->getItems();
        // If we don't find any cart items.
        if (!$cartItems) {
            // We display a flash message for the user.
            $this->addFlash('error', 'Vous ne pouvez pas passer une commande avec un panier vide.');

            // We redirect the user.
            return $this->redirectToRoute(
                'home',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We get the logged in user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // We create a array to backup each address.
        $addresses = [];
        foreach ($user->getAddresses() as $address) {
            // We push each $address in the array .
            $addresses[] = $address;
        }
        // If we don't find any addresses.
        if (!$addresses) {
            // We redirect the user.
            return $this->redirectToRoute(
                'address_create',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We call the getTotal() method of the Cart service to get the price total of all the products of the cart according to their quantity.
        $subtotal = $this->cart->getTotal();

        // We create a array to backup the prices of each delivery mode.
        $deliveryModePrices = [];
        // We create a array to backup the pictures of each delivery mode.
        $deliveryModePictures = [];
        foreach ($deliveryModeRepository->findAll() as $deliveryMode) {
            // We push each $deliveryModePrices in the array.
            $deliveryModePrices[] = $deliveryMode->getPrice();
            // We push each $deliveryModePictures in the array .
            $deliveryModePictures[] = $deliveryMode->getPicture();
        }

        // We use the PHP function min() to find lowest value in $deliveryModePrices.
        $deliveryModePrice = min($deliveryModePrices);
        // We find the delivery mode with the lowest delivery price.
        $deliveryMode = $deliveryModeRepository->findOneBy(['price' => $deliveryModePrice]);

        // The total is the subtotal + the delivery mode price.
        $total = $subtotal + $deliveryModePrice;

        // If the subtotal of the cart is superior or egual to the min purchase amount for free delivery of the delivery mode.
        if ($subtotal >= $deliveryMode->getMinCartAmountForFreeDelivery()) {
            // The delivery price change is value to DeliveryMode::DELIVERY_PRICE_FREE.
            $deliveryModePrice = DeliveryMode::DELIVERY_PRICE_FREE;
            // The total is only the subtotal.
            $total = $subtotal;
        }

        // We create a new Purchase.
        $purchase = new Purchase();
        // We set the user to the purchase.
        $purchase->setUser($user);
        // We create the form.
        $form = $this->createForm(PurchaseType::class, $purchase);
        // We link the form to the request.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We set the billing address to the purchase.
            $purchase->setBillingAddress($this->purchaseAddress->insertBreakLineCharactersInAddress($user, $form->get('billingAddress')->getData()));

            // We set the delivery address to the purchase.
            $purchase->setDeliveryAddress($this->purchaseAddress->insertBreakLineCharactersInAddress($user, $form->get('deliveryAddress')->getData()));

            // The delivery price is the price of the selected delivery mode.
            $deliveryModePrice = $form->get('deliveryMode')->getData()->getPrice();

            // If the price total of the cart is superior or equal than the minCartAmountForFreeDelivery of the selected deliveryMode.
            if ($this->cart->getTotal() >= $form->get('deliveryMode')->getData()->getMinCartAmountForFreeDelivery()) {
                // The delivery price is Purchase::DELIVERY_PRICE_FREE.
                $deliveryModePrice = DeliveryMode::DELIVERY_PRICE_FREE;
            }

            // We set some properties to the purchase.
            $purchase
                ->setSubtotal($this->cart->getTotal())
                ->setDeliveryModePrice($deliveryModePrice)
                ->setTotal($this->cart->getTotal() + $deliveryModePrice)
                // We set the status of the purchase with the value of the PHP constant Purchase::STATUS_PENDING_CHECKOUT because the payment has not yet been made and therefore the purchase is not yet confirmed. 
                ->setStatus(Purchase::STATUS_PENDING_CHECKOUT)
                // We set the bill of the purchase with the value of the PHP constant Purchase::BILL_BY_DEFAULT because the payment has not yet been made and therefore the purchase is not yet confirmed so it should not have a specific bill. 
                ->setBill(Purchase::BILL_BY_DEFAULT);

            // We call the persit() method of the EntityManagerInterface to put on hold the data.
            $this->entityManagerInterface->persist($purchase);

            foreach ($this->cart->getItems() as $cartItems) {
                // We create a new  PurchaseItem.
                $purchaseItem = new PurchaseItem();
                // We set the properties of the $purchaseItem.
                $purchaseItem
                    ->setPurchase($purchase)
                    ->setProductName($cartItems->product->getName())
                    ->setProductReference($cartItems->product->getReference())
                    ->setProductPrice($cartItems->product->getPrice())
                    ->setProduct($cartItems->product)
                    ->setQuantity($cartItems->quantity)
                    ->setTotal($cartItems->getTotal());

                // We call the persit() method of the EntityManagerInterface to put on hold the data.
                $this->entityManagerInterface->persist($purchaseItem);
            }

            //! START: Stripe checkout
            // If the payment method chosen by the user have the value of the PHP constant CHECKOUT_METHOD_CREDIT_CARD we start a Stripe checkout. 
            if ($form->get('checkoutMethod')->getData() === Purchase::CHECKOUT_METHOD_CREDIT_CARD) {
                // We create a new StripeCheckout with in argument the value of the environnement variable STRIPE_SECRET_KEY, the UrlGeneratorInterface and the EntityManagerInterface.
                $stripeCheckout = new StripeCheckout($_ENV['STRIPE_SECRET_KEY'], $urlGeneratorInterface, $this->entityManagerInterface);

                // The Stripe session is returned by the startStripeCheckout() method of the SripeCheckout service that we call with the cart, the purchase, the delivery mode price and the delivery mode description in argument.
                $stripeSession = $stripeCheckout->startStripeCheckout(
                    $this->cart,
                    $purchase,
                    $deliveryModePrice,
                    $form->get('deliveryMode')->getData()->getDescription()
                );

                // We set the Stripe Session Id to the purchase.
                $purchase->setStripeSessionId($stripeSession['id']);

                // We call the flush() method of the EntityManagerInterface to backup the data in the database.
                $this->entityManagerInterface->flush();

                // We call the startStripeCheckout() method of the SripeCheckout service with the cart, the purchase, the delivery mode price and the delivery mode description in argument so that the method return us the URL of the Stripe interface on wich we redirect the user.
                return $this->redirect($stripeSession['url']);
            }
            //! END: Stripe checkout 
            // TODO #3 START: Paypal checkout
            // Else if the payment method chosen by the user have the value of the PHP constant CHECKOUT_METHOD_PAYPAL we start a Paypal checkout. 
            else if ($form->get('checkoutMethod')->getData() === Purchase::CHECKOUT_METHOD_PAYPAL) {
                // We create a new PaypalCheckout with in argument the cart.
                $paypalCheckout = new PaypalCheckout($this->cart);
                // We call the showUserInterface() method of the PaypalCheckout service. 
                $paypalCheckout->showUserInterface();
            }
            // TODO #3 END: Paypal checkout

            //! START: if no checkout
            // // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            // $this->entityManagerInterface->flush();

            // // We redirect the user.
            // return $this->redirectToRoute(
            //     'purchase_stripe_success',
            //     [
            //         // We set a array of optional data.
            //         'reference' => $purchase->getReference()
            //     ],
            //     // We specify the related HTTP response status code.
            //     301
            // );
            //! END: if no checkout. 
        }

        // We display our template.
        return $this->render(
            'purchase/purchase.html.twig',
            // We set a array of optional data.
            [
                'purchaseForm' => $form->createView(),
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'deliveryModePrice' => $deliveryModePrice,
                'deliveryModePictureUploadFolderPath' => DeliveryMode::PICTURE_UPLOAD_FOLDER_PATH,
                'deliveryModePictures' => $deliveryModePictures,
                'total' => $total,
                'deliveryPriceFree' => DeliveryMode::DELIVERY_PRICE_FREE,
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the logged in user's purchases.
     * @param Request $request
     * @return Response
     */
    #[Route('/commandes', name: 'purchase_list', methods: 'GET', priority: 5)]
    public function list(Request $request): Response
    {
        // We get the logged in user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // We create a array to backup each purchase.
        $purchases = [];
        // For each $purchase in $user->getPurchases().
        foreach ($user->getPurchases() as $purchase) {
            //! START: purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.
            // // if the status of the purchase status is identical to the value of the PHP constant STATUS_ABANDONNED_CHECKOUT.
            // if ($purchase->getStatus() === Purchase::STATUS_ABANDONNED_CHECKOUT) {
            //     // We begin the next iteration of the loop so we don't put the purchase in the purchases array. 
            //     continue;
            // }
            //! END: purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.

            // We push each $purchase in the array.
            $purchases[] = $purchase;
        }

        // If we don't find any purchases.
        if (!$purchases) {
            // We display a flash message for the user.
            $this->addFlash('warning', 'Votre liste de commandes est vide car vous n\'avez passé aucune commande.');

            // We redirect the user.
            return $this->redirectToRoute(
                'home',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a new purchase search.
        $search = new PurchaseSearch();
        // We create the form.
        $form = $this->createForm(PurchaseSearchType::class, $search);
        // We link the form to the request.
        $form->handleRequest($request);

        // If the form is submitted and valid.
        if ($form->isSubmitted() && $form->isValid()) {
            // We find the purchase by its reference.
            $purchases = $this->purchaseRepository->findPurchaseByReference($search);

            // If we don't find a purchase with the submitted reference.
            if (!$purchases) {
                // We display a flash message for the user.
                $this->addFlash('error', 'La commande ' . $form->get('reference')->getData() . ' ne figure pas dans votre liste de commandes.');

                // We redirect the user.
                return $this->redirectToRoute(
                    'purchase_list',
                    // We set a array of optional data.
                    [],
                    // We specify the related HTTP response status code.
                    301
                );
            }

            // Foreach $purchase in $purchases.
            foreach ($purchases as $purchase) {
                // If the user of the purchase is not identical to the user.
                if ($purchase->getUser() !== $user) {
                    // We display a flash message for the user.
                    $this->addFlash('error', 'La commande ' . $form->get('reference')->getData() . ' ne figure pas dans votre liste de commandes.');

                    // We redirect the user.
                    return $this->redirectToRoute(
                        'purchase_list',
                        // We set a array of optional data.
                        [],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
            }
        }

        // We display our template.
        return $this->render(
            'purchase/list.html.twig',
            // We set a array of optional data.
            [
                'searchPurchaseForm' => $form->createView(),
                'purchases' => $purchases,
                'statusPaid' => Purchase::STATUS_PAID,
                'statusInProgress' => Purchase::STATUS_IN_PROGRESS,
                'statusSend' => Purchase::STATUS_SEND,
                'statusDeliver' => Purchase::STATUS_DELIVER,
                'statusAnnul' => Purchase::STATUS_ANNUL
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the detail of a logged in user's purchase.
     * @param int $id
     * @return Response
     */
    #[Route('/commandes/{reference}', name: 'purchase_detail', methods: 'GET')]
    public function detail(string $reference): Response
    {
        // We find the purchase by its reference.
        $purchase =  $this->purchaseRepository->findOneBy(['reference' => $reference]);

        // If we don't find any purchase or if the user of the purchase is not identical to the logged in.
        if (!$purchase || $purchase->getUser() !== $this->getUser()) {
            // We redirect the user.
            return $this->redirectToRoute(
                'purchase_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We create a array to backup each purchase item.
        $purchaseItems = [];
        // For each $adresse in $purchase->getAddresses().
        foreach ($purchase->getPurchaseItems() as $purchaseItem) {
            // We push each $address in the array .
            $purchaseItems[] = $purchaseItem;
        }

        // // Add "<br />" when find "\n".
        // $billingAddress = nl2br($purchase->getBillingAddress());
        // // Convert "\n" to "<br />".
        // $billingAddress = str_replace("\n", '<br>', $purchase->getBillingAddress());

        // We display our template.
        return $this->render(
            'purchase/detail.html.twig',
            // We set a array of optional data.
            [
                'purchase' => $purchase,
                'billingAddress' => $this->purchaseAddress->showAddress($purchase->getBillingAddress()),
                'deliveryAddress' => $this->purchaseAddress->showAddress($purchase->getDeliveryAddress()),
                'purchaseItems' => $purchaseItems,
                'statusPaid' => Purchase::STATUS_PAID,
                'statusInProgress' => Purchase::STATUS_IN_PROGRESS,
                'statusSend' => Purchase::STATUS_SEND,
                'statusDeliver' => Purchase::STATUS_DELIVER,
                'statusAnnul' => Purchase::STATUS_ANNUL
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that display the page that say to the user that is order has been confirmed and update the status of the purchase in the database.
     * @param Request $request 
     * @param Email $email
     * @return Response
     */
    #[Route('/commandes/{reference}/confirmation', name: 'purchase_stripe_success', methods: 'GET')]
    public function stripeSuccess(Request $request, Email $email): Response
    {
        // We get the logged in user.
        /**
         * @var User
         */
        $user = $this->getUser();

        // We find the purchase by its reference. 
        $purchase = $this->purchaseRepository->findOneBy(['reference' => $request->attributes->get('reference')]);

        // If
        if (
            // the purchase doesn't exist or
            !$purchase ||
            // the user of the purchase is not identical to the logged in user or 
            $purchase->getUser() !== $user ||
            // the status of the purchase not identical to the value of the PHP constant STATUS_PENDING_CHECKOUT.
            $purchase->getStatus() !== Purchase::STATUS_PENDING_CHECKOUT
        ) {
            // We redirect the user.
            return $this->redirectToRoute(
                'purchase_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We update some properties of the purchase.
        $purchase
            // We set the purchase status with the value of the PHP constant Purchase::STATUS_PAID because the checkout is confirm. 
            ->setStatus(Purchase::STATUS_PAID);
        // TODO START: set the bill of the purchase.

        // TODO END: set the bill of the purchase.



        // We call the flush() method of the EntityManagerInterface to backup the data in the database.
        $this->entityManagerInterface->flush();

        // We remove the cart form the session.
        $request->getSession()->remove('cart');

        // We create a array to backup each purchase items.
        $purchaseItems = [];
        // For each $purchaseItem in $purchase->getPurchaseItems().
        foreach ($purchase->getPurchaseItems() as $purchaseItem) {
            // We push each $purchaseItem in the array.
            $purchaseItems[] = $purchaseItem;
        }

        // We call the confimPurchaseToUser() method of the Email service with the logged in user and is purchase and purchase items in argument.
        $email->confimPurchaseToUser($user, $purchase, $purchaseItems);

        // We display our template.
        return $this->render(
            'purchase/success.html.twig',
            // We set a array of optional data.
            [
                'user' => $user,
                'purchase' => $purchase
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that download the purchase of the user according to the purchase reference. 
     * @param string $reference
     * @return Response
     */
    #[Route('/commandes/{reference}/telecharger/facture', name: 'purchase_download_bill', methods: 'GET')]
    public function downloadBill(string $reference): Response
    {
        // We find the purchase by its reference.
        $purchase =  $this->purchaseRepository->findOneBy(['reference' => $reference]);

        // If we don't find any purchase or if the user of the purchase is not identical to the logged in.
        if (!$purchase || $purchase->getUser() !== $this->getUser()) {
            // We redirect the user.
            return $this->redirectToRoute(
                'purchase_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // The path to the files is relative to the public folder.
        return $this->file(Purchase::BILL_UPLOAD_FOLDER_PATH . "/" . $purchase->getBill(), "facture-" . $purchase->getReference());
    }


    //! START: test of templated email
    // #[Route('/emails/purchase-confirmation', name: 'purchase_confirmation', methods: 'GET')]
    // public function confimPurchaseToUser(): Response
    // {
    //     // We get the logged in user.
    //     /**
    //      * @var User
    //      */
    //     $user = $this->getUser();

    //     // We get a purchase to display in our e-mail template.
    //     $purchase = $this->purchaseRepository->findOneBy(['id' => 187]);

    //     // We create a array to backup each purchase items.
    //     $purchaseItems = [];
    //     // For each $purchaseItem in $purchase->getPurchaseItems().
    //     foreach ($purchase->getPurchaseItems() as $purchaseItem) {
    //         // We push each $purchaseItem in the array.
    //         $purchaseItems[] = $purchaseItem;
    //     }

    //     // We display our template.
    //     return $this->render(
    //         'emails/purchase/confirmation.html.twig',
    //         // We set a array of optional data.
    //         [
    //             'user' => $user,
    //             'purchase' => $purchase,
    //             'billingAddress' => $this->purchaseAddress->showAddress($purchase->getBillingAddress()),
    //             'deliveryAddress' => $this->purchaseAddress->showAddress($purchase->getDeliveryAddress()),
    //             'purchaseItems' => $purchaseItems
    //         ],
    //         // We specify the related HTTP response status code.
    //         new Response('', 200)
    //     );
    // }
    //! END: test of templated email

}

<?php

namespace App\Controller;

use App\Entity\DeliveryMode;
use App\Entity\Purchase;
use App\Repository\DeliveryModeRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Service\Cart\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[IsGranted('ROLE_USER')]
class CartController extends AbstractController
{
    /**
     * 
     */
    public function __construct(protected ProductRepository $productRepository, protected Cart $cart)
    {
    }

    /**
     * Method that allow the user to add a product to his cart.
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route('/panier/ajouter/produits/{id}', name: 'cart_add', methods: 'GET', requirements: ['id' => '\d+'])]
    public function add(int $id, Request $request): Response
    {
        // We find the product by is id.
        $product = $this->productRepository->find($id);
        // If we don't find any product.
        if (!$product) {
            // We display a flash message for the user.
            $this->addFlash('error', 'Le produit que vous souhaitez ajouter à votre panier n\'existe pas.');

            // We redirect the user.
            return $this->redirectToRoute(
                'product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We call the add() method of the Cart service to add a product in the cart.
        $this->cart->add($id);

        // We create a array with our return values which is indicate in each link to add a product to the cart.  
        $retunValues = ['returnToHome', 'returnToProductList', 'returnToProductDetail', 'returnToCategoryProductList', 'returnToCategoryProductDetail', 'returnToAdminPurchaseCreate'];
        // For each $value in $retunValues.
        foreach ($retunValues as $value) {
            // If the query of the request contain one of the $retunValues.
            if ($request->query->get($value)) {
                // We display a flash message for the user.
                $this->addFlash('success', 'Le produit ' . $product->getName() . ' a bien été ajouté à votre panier.');

                // If the query of the request contain the key returnToHome.
                if ($request->query->get('returnToHome')) {
                    // We redirect the user.
                    return $this->redirectToRoute(
                        'home',
                        // We set a array of optional data.
                        [],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
                // Else if the query of the request contain the string returnToProductList.
                else if ($request->query->get('returnToProductList')) {
                    // We redirect the user.
                    return $this->redirectToRoute(
                        'product_list',
                        // We set a array of optional data.
                        [],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
                // Else if the query of the request contain the string returnToProductDetail.
                else if ($request->query->get('returnToProductDetail')) {
                    // We redirect the user.
                    return $this->redirectToRoute(
                        'product_detail',
                        // We set a array of optional data.
                        [
                            'slug' => $product->getSlug()
                        ],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
                // Else if the query of the request contain the string returnToCategoryProductList.
                else if ($request->query->get('returnToCategoryProductList')) {
                    // We redirect the user.
                    return $this->redirectToRoute(
                        'category_product_list',
                        // We set a array of optional data.
                        [
                            'slug' => $product->getCategory()->getSlug()
                        ],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
                // Else if the query of the request contain the string returnToCategoryProductDetail.
                else if ($request->query->get('returnToCategoryProductDetail')) {
                    // We redirect the user.
                    return $this->redirectToRoute(
                        'category_product_detail',
                        // We set a array of optional data.
                        [
                            'categorySlug' => $product->getCategory()->getSlug(),
                            'productSlug' => $product->getSlug()
                        ],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
                // Else if the query of the request contain the string returnToAdminPurchaseCreate.
                else if ($request->query->get('returnToAdminPurchaseCreate')) {
                    // We redirect the user.
                    return $this->redirectToRoute(
                        'admin_purchase_create',
                        // We set a array of optional data.
                        [
                            'id' => $request->attributes->get('id')
                        ],
                        // We specify the related HTTP response status code.
                        301
                    );
                }
            }
        }

        // We redirect the user.
        return $this->redirectToRoute(
            'cart_detail',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            301
        );
    }

    /**
     * Method that display the user's cart.
     * @param DeliveryModeRepository $deliveryModeRepository
     * @param PurchaseRepository $purchaseRepository
     * @param EntityManagerInterface entityManagerInterface
     * @return Response
     */
    #[Route('/panier', name: 'cart_detail', methods: 'GET', priority: 2)]
    public function detail(DeliveryModeRepository $deliveryModeRepository, PurchaseRepository $purchaseRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        // We find the purchase by is status.
        $purchase = $purchaseRepository->findOneBy(
            [
                'status' => Purchase::STATUS_PENDING_CHECKOUT,

            ]
        );

        // If we find a purchase with a status equal to the the value of the PHP constant Purchase::STATUS_PENDING_CHECKOUT that mean that the user has abandoned the checkout process and the purchase status remained with the value of the PHP constant Purchase::STATUS_PENDING_CHECKOUT that wat set in the purchase() method of the PurchaseController.
        if ($purchase) {
            //! START : purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.
            // // We set the purchase status with the value of the PHP constant Purchase::STATUS_ABANDONNED_CHECKOUT.
            // $purchase->setStatus(Purchase::STATUS_ABANDONNED_CHECKOUT);
            //! END : purchase backup with a status value to STATUS_ABANDONNED_CHECKOUT.

            // We call the remove() method of the EntityManagerInterface with the value of the object we want to remove.
            $entityManagerInterface->remove($purchase);

            // We call the flush() method of the EntityManagerInterface to backup the data in the database.
            $entityManagerInterface->flush();

            // // We display a flash message for the user.
            // $this->addFlash('success', 'Vous avez quitté le formulaire de paiement. Nous vous confirmons que le paiement a bien été abandonnée.');
        }

        // We call the getItems() method of the Cart service to get the detail of the CartItem() in the cart.
        $cartItems = $this->cart->getItems();

        // If we don't find any $cartItems. 
        if (!$cartItems) {
            // We display a flash message for the user. 
            $this->addFlash('warning', 'Votre panier est vide.');

            // We redirect the user.
            return $this->redirectToRoute(
                'home',
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
        // For each $deliveryMode in $deliveryModeRepository->findAll().
        foreach ($deliveryModeRepository->findAll() as $deliveryMode) {
            // We push each $deliveryModePrices in the array .
            $deliveryModePrices[] = $deliveryMode->getPrice();
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

        // We display our template.
        return $this->render(
            'cart/detail.html.twig',
            // We set a array of optional data.
            [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'deliveryModePrice' => $deliveryModePrice,
                'total' => $total
            ],
            // We specify the related HTTP response status code.
            new Response('', 200)
        );
    }

    /**
     * Method that delete a product from the cart.
     * @param int $id
     * @return Response
     */
    #[Route('/panier/produits/{id}/supprimer', name: 'cart_delete', methods: 'GET', requirements: ['id' => '\d+'])]
    public function delete(int $id): Response
    {
        // We find the product by is id.
        $product = $this->productRepository->find($id);
        // If we don't find any product.
        if (!$product) {
            // We display a flash message for the user.
            $this->addFlash('error', 'Le produit que vous souhaitez supprimer de votre panier n\'existe pas. Il ne peut donc pas être supprimé de votre panier.');

            // We redirect the user.
            return $this->redirectToRoute(
                'product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We call the delete() method of the Cart service to delete a product from the cart.
        $this->cart->delete($id);

        // We display a flash message for the user.
        $this->addFlash('success', 'Le produit ' . $product->getName() .  ' a bien été supprimé de votre panier.');

        // We redirect the user.
        return $this->redirectToRoute(
            'cart_detail',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            301
        );
    }

    /**
     * Method that decremente a product from the user's cart.
     * @param int $id
     * @return Response
     */
    #[Route('/panier/produits/{id}/decrementer', name: 'cart_decremente', methods: 'GET', requirements: ['id' => '\d+'])]
    public function decremente(int $id): Response
    {
        // We find the product by is id.
        $product = $this->productRepository->find($id);
        
        // If we don't find any product.
        if (!$product) {
            // We display a flash message for the user.
            $this->addFlash('error', 'Le produit que vous souhaitez décrémenter de votre panier n\'existe pas. Il ne peut donc pas être décrémenté de votre panier.');

            // We redirect the user.
            return $this->redirectToRoute(
                'product_list',
                // We set a array of optional data.
                [],
                // We specify the related HTTP response status code.
                301
            );
        }

        // We call the decremente() method of the Cart service to decremente a product from the cart.
        $this->cart->decremente($id);

        // We redirect the user.
        return $this->redirectToRoute(
            'cart_detail',
            // We set a array of optional data.
            [],
            // We specify the related HTTP response status code.
            301
        );
    }
}

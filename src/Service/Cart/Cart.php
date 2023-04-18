<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use App\Service\Cart\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(protected ProductRepository $productRepository, protected RequestStack $requestStack)
    {
    }

    /**
     * Method generate a uniq id. 
     * @return int  
     */
    public function getId(): int
    {
        // We use the PHP function uniqid() to generate a uniq id. 
        return (int) uniqid();
    }

    /**
     * Method that get the cart in session or if the cart doesn't exist get a empty array. 
     * @return array  
     */
    protected function getCart(): array
    {
        // We get the cart in the session or if the cart doesn't exist we get a empty array.
        return $this->requestStack->getSession()->get('cart', []);
    }

    /**
     * Method that save the data of the cart in session. 
     * @param array $cart
     * @return void  
     */
    protected function saveCart(array $cart)
    {
        // We push the data in the cart.
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /**
     * Methot that add a product in the cart. 
     * @param int $id 
     * @return void 
     */
    public function add(int $id)
    {
        // We call the getCart() method of the Cart service to get the cart in session.
        $cart = $this->getCart();

        // If the product doesn't exist in the cart.
        if (!array_key_exists($id, $cart)) {
            // We set to 0 the quantity of the product. 
            $cart[$id] = 0;
        }

        // We increment the cart with the new quantity of the product. 
        $cart[$id]++;

        // We call the saveCart() method of the Cart service to save the data of the cart in session.
        $this->saveCart($cart);
    }

    /**
     * Methot that delete a product from the cart. 
     * @param int $id 
     * @return void 
     */
    public function delete(int $id)
    {
        // We call the getCart() method of the Cart service to get the cart in session.
        $cart = $this->getCart();

        // We use the php method unset() to delete the product from the cart. 
        unset($cart[$id]);

        // We call the saveCart() method of the Cart service to save the data of the cart in session.
        $this->saveCart($cart);
    }

    /**
     * Methot that decremente a product from the cart. 
     * @param int $id 
     * @return void 
     */
    public function decremente(int $id)
    {
        // We call the getCart() method of the Cart service to get the cart in session.
        $cart = $this->getCart();

        // If the product doesn't exist in the cart.
        if (!array_key_exists($id, $cart)) {
            // We leave decremente().
            return;
        }

        // If the product quantity is 1. 
        if ($cart[$id] === 1) {
            // We call the delete() method of the Cart service to delete a product from the cart.
            $this->delete($id);
            // We leave decremente().
            return;
        }

        // If the product quantity is superior to 1 we decrement the quantity of the product in the cart. 
        $cart[$id]--;

        // We call the saveCart() method of the Cart service to save the data of the cart in session.
        $this->saveCart($cart);
    }

    /**
     * Methot that get all the CartItem() that exist in the cart. 
     * @return CartItem[] $items 
     */
    public function getItems(): array
    {
        // We create a array which will contain the products and their quantity.
        $items = [];

        // For each product in the cart, we get the his id of and his quantity.
        foreach ($this->getCart() as $id => $quantity) {
            // We get the product by his id. 
            $product = $this->productRepository->find($id);

            // If the product doesn't exist. 
            if (!$product) {
                // We ask the loop to continue. 
                continue;
            }

            // We create a new CartItem() with the product and his quantity.
            $items[] = new CartItem($product, $quantity);
        }

        // We return the detail of the cart.
        return $items;
    }

    /**
     * Methot that get the price total of all the products of the cart according to their quantity.
     * @return int $total 
     */
    public function getTotal(): int
    {
        // We set the value by default of the total. 
        $total = 0;

        // For each product in the cart, we get the his id of and his quantity.
        foreach ($this->getCart() as $id => $quantity) {
            // We find the product by is id.
            $product = $this->productRepository->find($id);

            // If the product doesn't exist. 
            if (!$product) {
                // We ask the loop to continue. 
                continue;
            }

            // The total is the price of each product multiply by his quantity.
            $total += $product->getPrice() * $quantity;
        }

        // We return the price total of the cart.
        return $total;
    }

    /**
     * Methot that get the number total of CartItem() in the cart. 
     * @return int $total 
     */
    public function getNumberOfItem(): int
    {
        // We set the value by default of the total. 
        $number = 0;

        // For each CartItem() we, get his quantity.
        foreach ($this->getCart() as $quantity) {
            // The quantity total is the sum of the quantity of each CartItem().
            $number += $quantity;
        }

        // We return the number total of CartItem() in the cart.
        return $number;
    }
}

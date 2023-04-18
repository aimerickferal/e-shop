<?php

namespace App\Service\Cart;

use App\Entity\Product;

class CartItem
{
    public function __construct(public Product $product, public int $quantity)
    {
    }

    /**
     * Method that return the price total of each product of the cart according to his quantity. 
     * @return int 
     */
    public function getTotal(): int
    {
        // We return the price total by product which is the price of a product multiply by his quantity.
        return $this->product->getPrice() * $this->quantity;
    }


    /**
     * Method that return the name of a product existing in the cart. 
     * @return string 
     */
    public function getName(): string
    {
        // We return the name of the product. 
        return $this->product->getName();
    }

    /**
     * Methot that retun the price of each cartItem().
     * @return int 
     */
    public function getPrice(): int
    {
        // We return the price of each CartItem(). 
        return $this->product->getPrice();
    }

    /**
     * Methot that retun the quantity of each cartItem().
     * @return int 
     */
    public function getQuantity(): int
    {
        // We return the quantity of each CartItem(). 
        return $this->quantity;
    }
}

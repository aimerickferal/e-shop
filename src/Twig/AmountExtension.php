<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AmountExtension extends AbstractExtension
{
    /**
     * Method that return the list of the available Twig filters. 
     * @return array 
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('amount', [$this, 'amount'])
        ];
    }

    /**
     * Method that format a price in cents to a price in decimal. 
     * @param int $price 
     * @param string $currencySymbol 
     * @param string $decimalSeparator 
     * @param string $thousandSeparator 
     * @return string $finalPrice 
     */
    public function amount($price, string $currencySymbol = '€', string $decimalSeparator = ',', string $thousandSeparator = ' '): string
    {
        // The final price is egual to the price divided by 100 because the price is in cents.
        $finalPrice = $price / 100;

        // We use the php function number_format() to format the number by grouping the thousands. 
        // We want 2 decimals, a comma to separate the cents from the decinal, and a space to separate the thousands. 
        $finalPrice = number_format($finalPrice, 2, $decimalSeparator, $thousandSeparator);

        // We return the final price with the currency symbol.
        return $finalPrice . ' ' . $currencySymbol;
    }
}

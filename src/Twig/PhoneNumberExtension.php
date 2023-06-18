<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneNumberExtension extends AbstractExtension
{
    /**
     * Method that return the list of the available Twig filters. 
     * @return array 
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('phone_number', [$this, 'phoneNumber'])
        ];
    }

    /**
     * Method that format a phone number to readable string by adding sapce between each block of two number.   
     * @param string $phoneNumber 
     * @return string  
     */
    public function phoneNumber(string $phoneNumber): string
    {
        return $phoneNumber[0] . $phoneNumber[1] . ' ' . $phoneNumber[2] . $phoneNumber[3] . ' ' . $phoneNumber[4] . $phoneNumber[5] . ' ' . $phoneNumber[6] . $phoneNumber[7] . ' ' . $phoneNumber[8] . $phoneNumber[9];
    }
}

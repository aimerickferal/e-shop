<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\User;

class PurchaseAddress
{
    /**
     * Methot that insert several break line characters "\n" in a submitted address in order to create a string that contain break line characters "\n" which we will use in the showAddress() method of this class. 
     * @param User $user
     * @param Address $address
     * @return string $address
     */
    public function insertBreakLineCharactersInAddress(User $user, Address $address): string
    {
        // The action realize in this loop can't be made in the PurchaseConfirmationType because it is not accepting the "\n" character like valid data. 
        // For each $userAddresses in $user->getAddresses().
        foreach ($user->getAddresses() as $userAddress) {
            // If the address identical to the user address.
            if ($address ===  $userAddress) {
                // We modify the data of the user address by adding the "\n" character at the end of the word from which we want to create a new break line. 
                $address =
                    $userAddress->getFirstName() . ' ' . $userAddress->getLastName() . "\n" . $userAddress->getStreetNumber() . ' ' . $userAddress->getStreetName() . "\n" . $userAddress->getZipCode() . ' - ' . $userAddress->getCity() . "\n" . $userAddress->getCountry() . "\n" . $userAddress->getPhoneNumber();

                // We return the addresses. 
                return $address;
            }
        }
    }

    /**
     * Methot that insert several break line characters "\n" in a submitted address in order to create a string that contain break line characters "\n" which we will use in the showAddress() method of this class. 
     * @param Address $address
     * @return string $address
     */
    public function insertBreakLineCharactersInAddressForFixtures(Address $address): string
    {
        // We modify the data of the user address by adding the "\n" character at the end of the word from which we want to create a new break line. 
        $newAddress =
            $address->getFirstName() . ' ' . $address->getLastName() . "\n" . $address->getStreetNumber() . ' ' . $address->getStreetName() . "\n" . $address->getZipCode() . ' - ' . $address->getCity() . "\n" . $address->getCountry() . "\n" . $address->getPhoneNumber();

        // We return the new addresses. 
        return $newAddress;
    }

    /**
     * Methot that custom made the layout of a givin address. 
     * @param  string $address
     * @return array $address
     */
    public function showAddress($address): array
    {
        // We have back up the adress in the database with the "\n" character at the end of each of each word from wich we want to add a break line. 
        // The "\n" character is not interpreted by the navigator so he it is invisible on the display. 

        // Presently, in the database, the address look like that : 
        // First name LAST NAME
        // Street number Street Name
        // Zip Code - City
        // Country
        // Phone number 

        // If we dump $purchase->getBillingAddress() the address will look like that : 
        // First name LAST NAME\n
        // Street number Street Name\n
        // Zip Code - City\n
        // Country\n
        // Phone number 

        // But if we display the address in the template it will look like that : 
        // First name LAST NAME Street number Street Name Zip Code - City Country Phone number 
        // All the data will be on the same line. 

        // In the template we want the adress to look like in the database which mean like that :  
        // First name LAST NAME
        // Street number Street Name
        // Zip Code - City
        // Country
        // Phone number 

        // We do the following process for each string we want to extract from the address : first name and last name, street number and street name, zip code and city, country and phone number. 

        // STEP #1 : We use the php method strtok() in order to split the address in smaller strings from the "\n" token. 

        // STEP #2 : We use the php method substr() in order to return a part of the address. 

        // STEP #3 : We use the php method strlen() in order to get the length of the string we extract from the address.  
        // The string return by substr() is the address less the length of the extracted string + 1 to exclude  "\n". 

        $firstNameAndLastName = strtok($address, "\n");
        $address = substr($address, strlen($firstNameAndLastName) + 1);

        $streetNameAndStreetNumber = strtok($address, "\n");
        $address = substr($address, strlen($streetNameAndStreetNumber) + 1);

        $zipCodeAndCity = strtok($address, "\n");
        $address = substr($address, strlen($zipCodeAndCity) + 1);

        $country = strtok($address, "\n");
        $address = substr($address, strlen($country) + 1);

        $phoneNumber = strtok($address, "\n");
        $address = substr($address, strlen($phoneNumber) + 1);

        return $address = [
            $firstNameAndLastName,
            $streetNameAndStreetNumber,
            $zipCodeAndCity,
            $country,
            $phoneNumber,
        ];
    }
}

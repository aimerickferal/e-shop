<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This Entity is not related to the database. 
 */
class PurchaseSearch
{
    // Proprietes availables in the object.
    #[Assert\NotBlank(message: 'Merci de saisir une référence.')]
    #[Assert\Length(
        min: 12,
        max: 12,
        minMessage: 'Merci de saisir au minimum {{ limit }} caractères.',
        maxMessage: 'Merci de saisir au maximum {{ limit }} caractères.',
    )]
    public $reference;

    public function __toString()
    {
        return $this->reference;
    }
}

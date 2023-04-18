<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This Entity is not related to the database. 
 */
class UserSearch
{
    // Proprietes availables in the object.
    #[Assert\NotBlank(message: "Merci de saisir un nom.")]
    public $lastName;

    public function __toString()
    {
        return $this->lastName;
    }
}

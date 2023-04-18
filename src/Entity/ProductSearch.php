<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This Entity is not related to the database. 
 */
class ProductSearch
{
    // Proprietes availables in the object.
    #[Assert\NotBlank(message: 'Merci de saisir un nom.')]
    public $name;

    public function __toString()
    {
        return $this->name;
    }
}

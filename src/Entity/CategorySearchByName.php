<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This Entity is not related to the database. 
 */
class CategorySearchByName
{
    // Proprietes availables in the object.
    #[Assert\NotBlank(message: 'Merci de sélectionner une catégorie.')]
    public $name;

    public function __toString()
    {
        return $this->name;
    }
}

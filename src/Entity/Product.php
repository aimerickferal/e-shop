<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    // The path to the folder of the product picture. 
    const PRODUCT_PICTURE_UPLOAD_FOLDER_PATH = 'assets/uploads/products';

    // The differents possible availability for product. 
    const AVAILABLE = 'Disponible';
    const UNAVAILABLE = 'Indisponible';

    // The Product picture by default.
    const PICTURE_BY_DEFAULT = 'product.png';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir un nom.')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Merci de saisir une description.')]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Assert\NotBlank(message: 'Merci de sélectionner une catégorie.')]
    private ?Category $category = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Merci de saisir un prix en euros.')]
    #[Assert\Regex(
        pattern: '/\d+/',
        message: 'Merci de saisir un prix en euros.',
    )]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de sélectionner une valeur.')]
    private ?string $availability = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }
}

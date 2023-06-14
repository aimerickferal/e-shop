<?php

namespace App\Entity;

use App\Repository\DeliveryModeRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DeliveryModeRepository::class)]
class DeliveryMode
{
    // The path to the folder of the delivery mode picture. 
    const PICTURE_UPLOAD_FOLDER_PATH = 'assets/uploads/delivery-modes';

    // The value in cents of the free deliveryPrice. 
    const DELIVERY_PRICE_FREE = 0;

    // The value of the DeliveryMode picture by default.
    const PICTURE_BY_DEFAULT = 'delivery-mode.svg';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir un nom.')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Merci de saisir une description.')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Merci de saisir un prix en euros.')]
    #[Assert\Regex(
        // Regex that match only value that contain a digit.
        pattern: '/\d+/',
        message: 'Merci de saisir un prix en euros.',
    )]
    private ?int $price = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Merci de saisir un prix en euros.')]
    #[Assert\Regex(
        // Regex that match only value that contain a digit.
        pattern: '/\d+/',
        message: 'Merci de saisir un prix en euros.',
    )]
    private ?int $minCartAmountForFreeDelivery = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->name;
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMinCartAmountForFreeDelivery(): ?int
    {
        return $this->minCartAmountForFreeDelivery;
    }

    public function setMinCartAmountForFreeDelivery(int $minCartAmountForFreeDelivery): self
    {
        $this->minCartAmountForFreeDelivery = $minCartAmountForFreeDelivery;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

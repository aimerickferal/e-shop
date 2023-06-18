<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    // The the differents checkoutMethod.
    // const CHECKOUT_PENDING = 'En attente de choix';
    public const CHECKOUT_METHOD_CARD_WITH_STRIPE = 'Paiment par carte bancaire via Stripe';
    public const CHECKOUT_METHOD_PAYPAL = 'Paiment via Paypal';
    public const CHECKOUT_METHOD_DISPOSAL = 'Commande interne';

    // The differents status.
    public const STATUS_PENDING_CHECKOUT = 'En attente de paiment';
    // const STATUS_ABANDONNED_CHECKOUT = 'Paiement abandonné';
    public const STATUS_PAID = 'Payée';
    public const STATUS_IN_PROGRESS = 'En cours de préparation';
    public const STATUS_SEND = 'Expédiée';
    public const STATUS_DELIVER = 'Livrée';
    public const STATUS_ANNUL = 'Annulée';

    // The path to the folder of the uploaded bills. 
    public const BILL_UPLOAD_FOLDER_PATH = 'assets/uploads/bills';

    // The bill by default.
    public const BILL_BY_DEFAULT = "bill.pdf";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Merci de sélectionner une adresse de facturation.')]
    private ?string $billingAddress = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Merci de sélectionner une adresse de livraison.')]
    private ?string $deliveryAddress = null;

    #[ORM\Column]
    private ?int $subtotal = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de sélectionner un mode de livraison.')]
    private ?string $deliveryMode = null;

    #[ORM\Column]
    private ?int $deliveryModePrice = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\Column(length: 255)]
    private ?string $checkoutMethod = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripeSessionId = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bill = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    private ?User $User = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $purchasedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: PurchaseItem::class)]
    private Collection $purchaseItems;

    public function __construct()
    {
        $this->purchasedAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->purchaseItems = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->reference;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getSubtotal(): ?int
    {
        return $this->subtotal;
    }

    public function setSubtotal(int $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getDeliveryMode(): ?string
    {
        return $this->deliveryMode;
    }

    public function setDeliveryMode(string $deliveryMode): self
    {
        $this->deliveryMode = $deliveryMode;

        return $this;
    }

    public function getDeliveryModePrice(): ?int
    {
        return $this->deliveryModePrice;
    }

    public function setDeliveryModePrice(int $deliveryModePrice): self
    {
        $this->deliveryModePrice = $deliveryModePrice;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCheckoutMethod(): ?string
    {
        return $this->checkoutMethod;
    }

    public function setCheckoutMethod(string $checkoutMethod): self
    {
        $this->checkoutMethod = $checkoutMethod;

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBill(): ?string
    {
        return $this->bill;
    }

    public function setBill(?string $bill): self
    {
        $this->bill = $bill;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPurchasedAt(): ?\DateTimeImmutable
    {
        return $this->purchasedAt;
    }

    public function setPurchasedAt(\DateTimeImmutable $purchasedAt): self
    {
        $this->purchasedAt = $purchasedAt;

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

    /**
     * @return Collection<int, PurchaseItem>
     */
    public function getPurchaseItems(): Collection
    {
        return $this->purchaseItems;
    }

    public function addPurchaseItem(PurchaseItem $purchaseItem): self
    {
        if (!$this->purchaseItems->contains($purchaseItem)) {
            $this->purchaseItems->add($purchaseItem);
            $purchaseItem->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseItem(PurchaseItem $purchaseItem): self
    {
        if ($this->purchaseItems->removeElement($purchaseItem)) {
            // set the owning side to null (unless already changed)
            if ($purchaseItem->getPurchase() === $this) {
                $purchaseItem->setPurchase(null);
            }
        }

        return $this;
    }
}

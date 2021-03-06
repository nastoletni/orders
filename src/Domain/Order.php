<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Nastoletni\Orders\Infrastructure\Doctrine\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * Cost of delivery. Added to final price.
     *
     * TODO: Maintain delivery in more appropriate way.
     */
    public const DELIVERY_COST = 15.00;

    public const UNACCEPTED = 0;
    public const ACCEPTED = 1;
    public const PAID = 2;
    public const SENT = 3;
    public const DELIVERED = 4;

    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @var OrderedItem[]
     *
     * @ORM\OneToMany(targetEntity="OrderedItem", mappedBy="order", cascade={"persist", "remove"})
     */
    private $orderedItems;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $comments;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $stage;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $placedAt;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->orderedItems = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Collection
     */
    public function getOrderedItems(): Collection
    {
        return $this->orderedItems;
    }

    /**
     * @param OrderedItem $item
     */
    public function addOrderedItem(OrderedItem $item): void
    {
        $this->orderedItems->add($item);
    }

    /**
     * Returns total money for order.
     *
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->orderedItems as $orderedItem) {
            $total += $orderedItem->getAmount() * $orderedItem->getItem()->getPrice();
        }

        $total += self::DELIVERY_COST;

        return $total;
    }

    /**
     * @return string
     */
    public function getComments(): string
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return int
     */
    public function getStage(): int
    {
        return $this->stage;
    }

    public function setUnaccepted(): void
    {
        $this->stage = self::UNACCEPTED;
    }

    public function setAccepted(): void
    {
        $this->stage = self::ACCEPTED;
    }

    public function setPaid(): void
    {
        $this->stage = self::PAID;
    }

    public function setSent(): void
    {
        $this->stage = self::SENT;
    }

    public function setDelivered(): void
    {
        $this->stage = self::DELIVERED;
    }

    /**
     * @return DateTime
     */
    public function getPlacedAt(): DateTime
    {
        return $this->placedAt;
    }

    /**
     * @param DateTime $placedAt
     */
    public function setPlacedAt(DateTime $placedAt): void
    {
        $this->placedAt = $placedAt;
    }
}
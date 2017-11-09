<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class OrderItem
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="items")
     */
    private $order;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     */
    private $item;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item): void
    {
        $this->item = $item;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
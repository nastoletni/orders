<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command;

class PlaceOrderCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $address;

    /**
     * @var array
     */
    private $items;

    /**
     * @var string
     */
    private $comments;

    /**
     * PlaceOrder constructor.
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $address
     * @param array $items
     * @param string $comments
     */
    public function __construct(
        string $name,
        string $phone,
        string $email,
        string $address,
        array $items,
        string $comments
    ) {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->items = $items;
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getComments(): string
    {
        return $this->comments;
    }
}
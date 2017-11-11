<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;

use Nastoletni\Orders\Domain\Exception\OrderNotFoundException;

interface OrderRepository
{
    /**
     * @param string $id
     *
     * @throws OrderNotFoundException
     *
     * @return Order
     */
    public function byId(string $id): Order;

    /**
     * @return Order[]
     */
    public function all(): array;

    /**
     * @param Order $order
     */
    public function save(Order $order): void;

    /**
     * @param Order $order
     */
    public function delete(Order $order): void;
}
<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;

interface OrderRepository
{
    /**
     * @param Order $order
     */
    public function save(Order $order): void;
}
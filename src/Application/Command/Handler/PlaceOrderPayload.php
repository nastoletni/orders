<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler;

class PlaceOrderPayload
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var float
     */
    private $total;

    /**
     * PlaceOrderPayload constructor.
     *
     * @param string $orderId
     * @param float $total
     */
    public function __construct(string $orderId, float $total)
    {
        $this->orderId = $orderId;
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }
}
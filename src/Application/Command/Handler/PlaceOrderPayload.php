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
     * PlaceOrderPayload constructor.
     *
     * @param string $orderId
     */
    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }
}
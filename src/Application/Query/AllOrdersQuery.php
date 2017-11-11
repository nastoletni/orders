<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Query;

use Nastoletni\Orders\Domain\OrderRepository;
use Symfony\Component\HttpFoundation\Request;

class AllOrdersQuery
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * AllOrdersQuery constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): array
    {
        $orders = $this->orderRepository->all();
        $ordersArray = [];

        foreach ($orders as $order) {
            $items = [];
            foreach ($order->getOrderedItems() as $orderedItem) {
                $items[] = [
                    'id' => $orderedItem->getItem()->getId(),
                    'amount' => $orderedItem->getAmount(),
                    'item' => [
                        'name' => $orderedItem->getItem()->getName(),
                        'price' => $orderedItem->getItem()->getPrice()
                    ]
                ];
            }

            $ordersArray[] = [
                'id' => $order->getId(),
                'name' => $order->getName(),
                'phone' => $order->getPhone(),
                'email' => $order->getEmail(),
                'address' => $order->getAddress(),
                'items' => $items,
                'comments' => $order->getComments(),
                'stage' => $order->getStage(),
                'placedAt' => $order->getPlacedAt()->getTimestamp()
            ];
        }

        return $ordersArray;
    }
}
<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler;

use DateTime;
use Nastoletni\Orders\Application\Command\PlaceOrder;
use Nastoletni\Orders\Domain\ItemRepository;
use Nastoletni\Orders\Domain\Order;
use Nastoletni\Orders\Domain\OrderItem;
use Nastoletni\Orders\Domain\OrderRepository;

class PlaceOrderHandler
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * PlaceOrderHandler constructor.
     *
     * @param OrderRepository $orderRepository
     * @param ItemRepository $itemRepository
     */
    public function __construct(OrderRepository $orderRepository, ItemRepository $itemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param PlaceOrder $command
     *
     * @return PlaceOrderPayload
     */
    public function handle(PlaceOrder $command): PlaceOrderPayload
    {
        $order = new Order();
        $order->setName($command->getName());
        $order->setPhone($command->getPhone());
        $order->setEmail($command->getEmail());
        $order->setAddress($command->getAddress());
        $order->setComments($command->getComments());

        $order->setUnaccepted();
        $order->setPlacedAt(new DateTime());

        foreach ($command->getItems() as $commandItem) {
            $item = $this->itemRepository->byId($commandItem['id']);

            $orderItem = new OrderItem();
            $orderItem->setAmount(intval($commandItem['amount']));
            $orderItem->setItem($item);

            $order->addItem($orderItem);
        }

        $this->orderRepository->save($order);

        return new PlaceOrderPayload(
            $order->getId()
        );
    }
}
<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler;

use DateTime;
use Nastoletni\Orders\Application\Command\PlaceOrderCommand;
use Nastoletni\Orders\Domain\Exception\ItemNotFoundException;
use Nastoletni\Orders\Domain\ItemRepository;
use Nastoletni\Orders\Domain\Order;
use Nastoletni\Orders\Domain\OrderedItem;
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
     * @param PlaceOrderCommand $command
     *
     * @throws Exception\ItemNotFoundException
     *
     * @return PlaceOrderPayload
     */
    public function handle(PlaceOrderCommand $command): PlaceOrderPayload
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
            if (intval($commandItem['amount']) == 0) {
                // Don't order items with amount of 0.
                continue;
            }

            try {
                $item = $this->itemRepository->byId($commandItem['id']);
            } catch (ItemNotFoundException $e) {
                throw new Exception\ItemNotFoundException($e->getMessage());
            }

            $orderItem = new OrderedItem();
            $orderItem->setAmount(intval($commandItem['amount']));
            $orderItem->setOrder($order);
            $orderItem->setItem($item);

            $order->addOrderedItem($orderItem);
        }

        $this->orderRepository->save($order);

        return new PlaceOrderPayload(
            $order->getId(),
            $order->getTotal()
        );
    }
}
<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler;

use DateTime;
use Nastoletni\Orders\Application\Command\Handler\Exception\OrderNotValidException;
use Nastoletni\Orders\Application\Command\PlaceOrderCommand;
use Nastoletni\Orders\Domain\Exception\ItemNotFoundException;
use Nastoletni\Orders\Domain\ItemRepository;
use Nastoletni\Orders\Domain\Order;
use Nastoletni\Orders\Domain\OrderedItem;
use Nastoletni\Orders\Domain\OrderRepository;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Exception\NoSuchMetadataException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\Validation;

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
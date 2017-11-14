<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler;

use InvalidArgumentException;
use Nastoletni\Orders\Application\Command\ChangeOrderStageCommand;
use Nastoletni\Orders\Domain\Exception\OrderNotFoundException;
use Nastoletni\Orders\Domain\Order;
use Nastoletni\Orders\Domain\OrderRepository;

class ChangeOrderStageHandler
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * ChangeOrderStageHandler constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param ChangeOrderStageCommand $command
     *
     * @throws Exception\OrderNotFoundException
     */
    public function handle(ChangeOrderStageCommand $command)
    {
        try {
            $order = $this->orderRepository->byId($command->getId());
        } catch (OrderNotFoundException $e) {
            throw new Exception\OrderNotFoundException($e->getMessage());
        }

        switch ($command->getStage()) {
            case Order::UNACCEPTED:
                $order->setUnaccepted();
                break;
            case Order::ACCEPTED:
                $order->setAccepted();
                break;
            case Order::PAID:
                $order->setPaid();
                break;
            case Order::SENT:
                $order->setSent();
                break;
            case Order::DELIVERED:
                $order->setDelivered();
                break;
            default:
                throw new InvalidArgumentException('Invalid stage given.');
        }

        $this->orderRepository->save($order);
    }
}
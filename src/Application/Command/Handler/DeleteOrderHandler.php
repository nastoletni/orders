<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler;

use Nastoletni\Orders\Application\Command\DeleteOrderCommand;
use Nastoletni\Orders\Domain\Exception\OrderNotFoundException;
use Nastoletni\Orders\Domain\OrderRepository;

class DeleteOrderHandler
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * DeleteOrderHandler constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param DeleteOrderCommand $command
     *
     * @throws Exception\OrderNotFoundException
     */
    public function handle(DeleteOrderCommand $command): void
    {
        try {
            $order = $this->orderRepository->byId($command->getId());
        } catch(OrderNotFoundException $e) {
            throw new Exception\OrderNotFoundException($e->getMessage());
        }

        $this->orderRepository->delete($order);
    }
}
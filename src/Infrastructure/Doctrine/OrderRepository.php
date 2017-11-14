<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository;
use Nastoletni\Orders\Domain\Exception\OrderNotFoundException;
use Nastoletni\Orders\Domain\Order;
use Nastoletni\Orders\Domain\OrderRepository as DomainOrderRepository;

class OrderRepository extends EntityRepository implements DomainOrderRepository
{
    /**
     * {@inheritdoc}
     */
    public function byId(string $id): Order
    {
        /** @var Order|null $order */
        $order = $this->find($id);

        if (!$order) {
            throw new OrderNotFoundException(sprintf('Order with id %s does not exist.', $id));
        }

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this
            ->createQueryBuilder('o')
            ->select('o')
            ->orderBy('o.placedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Order $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Order $order): void
    {
        $this->getEntityManager()->remove($order);
        $this->getEntityManager()->flush();
    }
}
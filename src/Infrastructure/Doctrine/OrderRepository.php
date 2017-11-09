<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository;
use Nastoletni\Orders\Domain\Order;
use Nastoletni\Orders\Domain\OrderRepository as DomainOrderRepository;

class OrderRepository extends EntityRepository implements DomainOrderRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Order $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }
}
<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository;
use Nastoletni\Orders\Domain\Exception\ItemNotFoundException;
use Nastoletni\Orders\Domain\Item;
use Nastoletni\Orders\Domain\ItemRepository as DomainItemRepository;

class ItemRepository extends EntityRepository implements DomainItemRepository
{
    /**
     * {@inheritdoc}
     */
    public function byId(int $id): Item
    {
        /** @var Item|null $item */
        $item = $this->find($id);

        if (!$item) {
            throw new ItemNotFoundException(sprintf('Item with id %d does not exist.', $id));
        }

        return $item;
    }

    /**
     * @return Item[]
     */
    public function all(): array
    {
        return $this->findAll();
    }
}
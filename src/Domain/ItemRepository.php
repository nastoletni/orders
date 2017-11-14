<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;

use Nastoletni\Orders\Domain\Exception\ItemNotFoundException;

interface ItemRepository
{
    /**
     * @param int $id
     *
     * @throws ItemNotFoundException
     *
     * @return Item
     */
    public function byId(int $id): Item;

    /**
     * @return Item[]
     */
    public function all(): array;
}
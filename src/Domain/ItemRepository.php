<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;

interface ItemRepository
{
    public function byId(int $id): Item;
}
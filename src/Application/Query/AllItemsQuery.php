<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Query;

use Nastoletni\Orders\Domain\ItemRepository;

class AllItemsQuery
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * AllItemsQuery constructor.
     *
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return array
     */
    public function query(): array
    {
        $items = $this->itemRepository->all();
        $itemsArray = [];

        foreach ($items as $item) {
            $itemsArray[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'price' => $item->getPrice()
            ];
        }

        return $itemsArray;
    }
}
<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Item
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return round($this->price / 100, 2);
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = round($price * 100);
    }
}
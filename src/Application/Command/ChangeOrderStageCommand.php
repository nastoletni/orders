<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command;

class ChangeOrderStageCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $stage;

    /**
     * ChangeOrderStage constructor.
     *
     * @param string $id
     * @param int $stage
     */
    public function __construct(string $id, int $stage)
    {
        $this->id = $id;
        $this->stage = $stage;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStage(): int
    {
        return $this->stage;
    }
}
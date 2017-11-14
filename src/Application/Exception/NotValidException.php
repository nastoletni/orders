<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

abstract class NotValidException extends Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    /**
     * OrderNotValidException constructor.
     *
     * @param ConstraintViolationListInterface $violations
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(ConstraintViolationListInterface $violations, string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->violations = $violations;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return ExceptionUtils::violationsToArray($this->violations);
    }
}
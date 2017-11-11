<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Command\Handler\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class OrderNotValidException extends Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $errors;

    /**
     * OrderNotValidException constructor.
     *
     * @param ConstraintViolationListInterface $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(ConstraintViolationListInterface $errors, string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
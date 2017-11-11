<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class OrderValidator
{
    public function validate(Request $request): ConstraintViolationListInterface
    {
        return new ConstraintViolationList();
    }
}
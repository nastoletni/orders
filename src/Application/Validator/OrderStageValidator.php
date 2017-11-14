<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class OrderStageValidator
{
    public function validate(Request $request): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();

        $validator->validate($request->request, [
           new Obje
        ]);
    }
}
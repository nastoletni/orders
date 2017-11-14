<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Validator;

use Nastoletni\Orders\Application\Command\Handler\Exception\OrderStageNotValidException;
use Nastoletni\Orders\Domain\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class OrderStageValidator
{
    /**
     * @param Request $request
     *
     * @throws OrderStageNotValidException
     */
    public function validate(Request $request): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($request->request->getIterator(), [
            new Assert\Collection([
                'stage' => [
                    new Assert\NotNull(),
                    new Assert\Type('integer'),
                    new Assert\Range([
                        'min' => Order::UNACCEPTED,
                        'max' => Order::DELIVERED
                    ])
                ]
            ])
        ]);

        if (count($violations) > 0) {
            throw new OrderStageNotValidException($violations);
        }
    }
}
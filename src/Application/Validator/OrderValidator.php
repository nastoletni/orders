<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Validator;

use Nastoletni\Orders\Application\Command\Handler\Exception\OrderNotValidException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class OrderValidator
{
    public function validate(Request $request): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($request->request->getIterator(), [
            new Assert\Collection([
                'name' => [
                    new Assert\NotNull()
                ],
                'phone' => [
                    new Assert\NotNull(),
                    new Assert\Regex('/\+?[0-9 ]{9,}/')
                ],
                'email' => [
                    new Assert\NotNull(),
                    new Assert\Email()
                ],
                'address' => [
                    new Assert\NotNull()
                ],
                'items' => new Assert\All([
                    new Assert\Collection([
                        'id' => [
                            new Assert\NotNull(),
                            new Assert\Type('integer')
                        ],
                        'amount' => [
                            new Assert\NotNull(),
                            new Assert\Type('integer')
                        ]
                    ])
                ]),
                'comments' => []
            ])
        ]);

        if (count($violations) > 0) {
            var_dump($violations);
            throw new OrderNotValidException($violations);
        }
    }
}
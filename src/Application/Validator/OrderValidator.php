<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Validator;

use Nastoletni\Orders\Application\Command\Handler\Exception\OrderNotValidException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class OrderValidator
{
    /**
     * @param Request $request
     *
     * @throws OrderNotValidException
     */
    public function validate(Request $request): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($request->request->getIterator(), [
            new Assert\Collection([
                'name' => [
                    new Assert\NotNull()
                ],
                'phone' => [
                    new Assert\NotNull()
                ],
                'email' => [
                    new Assert\NotNull(),
                    new Assert\Email()
                ],
                'address' => [
                    new Assert\NotNull()
                ],
                'items' => [
                    new Assert\NotBlank(),
                    new Assert\All([
                        new Assert\Collection([
                            'id' => [
                                new Assert\NotNull(),
                                new Assert\Type('integer')
                            ],
                            'amount' => [
                                new Assert\NotNull(),
                                new Assert\Type('integer'),
                                new Assert\Range(['min' => 1])
                            ]
                        ])
                    ])
                ],
                'comments' => []
            ])
        ]);

        if (count($violations) > 0) {
            throw new OrderNotValidException($violations);
        }
    }
}
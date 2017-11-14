<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ExceptionUtils
{
    /**
     * @param ConstraintViolationListInterface $violations
     *
     * @return array
     */
    public static function violationsToArray(ConstraintViolationListInterface $violations): array
    {
        $array = [];

        foreach ($violations as $violation) {
            // Separate nested fields with dot.
            $property = str_replace(['][', '[', ']'], ['.', '', ''], $violation->getPropertyPath());
            if (!isset($array[$property])) {
                $array[$property] = [];
            }

            $array[$property][] = $violation->getMessage();
        }

        return $array;
    }
}
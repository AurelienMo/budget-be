<?php

declare(strict_types=1);

/*
 * This file is part of budget-be
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Common\EntityFactory;

use App\Domain\Common\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ErrorsFactory
 */
class ErrorsFactory
{
    /**
     * @param ConstraintViolationListInterface $constraintList
     *
     * @throws ValidatorException
     */
    public static function buildErrors(ConstraintViolationListInterface $constraintList)
    {
        $errors = [];
        /** @var ConstraintViolationInterface $constraint */
        foreach ($constraintList as $constraint) {
            $errors[$constraint->getPropertyPath()][] = $constraint->getMessage();
        }
        throw new ValidatorException(
            Response::HTTP_BAD_REQUEST,
            $errors
        );
    }
}

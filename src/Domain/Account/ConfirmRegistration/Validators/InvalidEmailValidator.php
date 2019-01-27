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

namespace App\Domain\Account\ConfirmRegistration\Validators;

use App\Domain\Account\ConfirmRegistration\ConfirmRegistrationInput;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class InvalidEmailValidator
 */
class InvalidEmailValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * InvalidEmailValidator constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     *
     * @throws NonUniqueResultException
     */
    public function validate(
        $value,
        Constraint $constraint
    ) {
        /** @var ConfirmRegistrationInput $object */
        $object = $this->context->getObject();
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->loadByTokenActivation($object->getToken());

        if ($user->getEmail() !== $value) {
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}

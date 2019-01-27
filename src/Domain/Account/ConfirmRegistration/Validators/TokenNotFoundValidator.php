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
 * Class TokenNotFoundValidator
 */
class TokenNotFoundValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * TokenNotFoundValidator constructor.
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
        $user = $this->entityManager->getRepository(User::class)->loadUserByUsername($object->getEmail());

        if ($user->getTokenActivation() !== $value) {
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}

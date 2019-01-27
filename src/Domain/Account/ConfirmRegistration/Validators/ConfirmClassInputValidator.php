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
use App\Domain\Common\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ConfirmClassInputValidator
 */
class ConfirmClassInputValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * ConfirmClassInputValidator constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }


    /**
     * @param ConfirmRegistrationInput $value
     * @param Constraint               $constraint
     *
     * @throws NonUniqueResultException
     */
    public function validate(
        $value,
        Constraint $constraint
    ) {
        /** @var User $user */

        if ($value->getToken() && $value->getEmail()) {
            /** @var UserRepository $repo */
            $repo = $this->entityManager->getRepository(User::class);
            $user = $repo->loadByTokenActivation($value->getToken());

            if (is_null($user)) {
                $this->context->buildViolation('L\'identifiant unique fourni est incorrect.')
                              ->addViolation();
            }
            if ($user && $value->getEmail() !== $user->getEmail()) {
                $this->context->buildViolation(
                    'Merci de vérifier l\'adresse email avec laquelle vous vous êtes inscrit dans votre boite mail.'
                )
                    ->addViolation();
            }
        }
    }
}

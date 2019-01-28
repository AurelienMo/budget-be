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

namespace App\Domain\Account\ResetPassword\Validators;

use App\Domain\Account\ResetPassword\ResetPasswordInput;
use App\Domain\Common\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class ConfirmResetPasswordInputClassValidator
 */
class ConfirmResetPasswordInputClassValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * ConfirmResetPasswordInputClassValidator constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ResetPasswordInput $value
     * @param Constraint         $constraint
     *
     * @throws NonUniqueResultException
     */
    public function validate(
        $value,
        Constraint $constraint
    ) {
        if ($value->getToken() && $value->getEmail()) {
            /** @var UserRepository $repo */
            $repo = $this->entityManager->getRepository(User::class);
            $user = $repo->loadByTokenResetPassword($value->getToken());
            if (is_null($user)) {
                $this->context->buildViolation('L\'identifiant unique fourni est invalide.')
                              ->addViolation();
            }
            if ($user && $value->getEmail() !== $user->getEmail()) {
                $this->context->buildViolation('L\'adresse email est invalide.')
                              ->addViolation();
            }
        }
    }
}

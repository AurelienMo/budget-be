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

namespace App\Domain\BankAccount\Validators;

use App\Domain\Common\Repository\CfgBankRepository;
use App\Entity\CfgBank;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class CfgBankNotExistValidator
 */
class CfgBankNotExistValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * CfgBankNotExistValidator constructor.
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
     */
    public function validate(
        $value,
        Constraint $constraint
    ) {
        /** @var CfgBankNotExist $valueConstraint */
        $valueConstraint = $constraint;
        if (is_null($value)) {
            return;
        }

        /** @var CfgBankRepository $repo */
        $repo = $this->entityManager->getRepository(CfgBank::class);
        $cfgBank = $repo->loadByKeywords($value);

        if (empty($cfgBank)) {
            $this->context->buildViolation($valueConstraint->message)
                          ->addViolation();
        }
    }
}

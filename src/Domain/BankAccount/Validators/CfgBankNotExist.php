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

use Symfony\Component\Validator\Constraint;

/**
 * Class CfgBankNotExist
 *
 * @Annotation
 */
class CfgBankNotExist extends Constraint
{
    public $message = 'Invalid value';
}

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

use Symfony\Component\Validator\Constraint;

/**
 * Class ConfirmResetPasswordInputClass
 *
 * @Annotation
 */
class ConfirmResetPasswordInputClass extends Constraint
{
    public $message = 'Some value are invalid';

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}

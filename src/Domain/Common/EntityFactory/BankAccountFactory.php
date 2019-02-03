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

use App\Entity\Account;
use App\Entity\CfgBank;
use App\Entity\User;

/**
 * Class BankAccountFactory
 */
class BankAccountFactory
{
    /**
     * @param CfgBank $cfgBank
     * @param string  $name
     * @param float   $initialBalance
     * @param User    $user
     *
     * @return Account
     *
     * @throws \Exception
     */
    public static function create(
        CfgBank $cfgBank,
        string $name,
        float $initialBalance,
        User $user
    ) {
        return new Account(
            $cfgBank,
            $name,
            $initialBalance,
            $user
        );
    }
}

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

use App\Entity\CfgBank;

/**
 * Class CfgBankFactory
 */
class CfgBankFactory
{
    /**
     * @param string $name
     *
     * @return CfgBank
     *
     * @throws \Exception
     */
    public static function create(
        string $name
    ) {
        return new CfgBank($name);
    }
}

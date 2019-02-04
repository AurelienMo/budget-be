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

namespace App\Domain\BankAccount\Detail;

use App\Domain\AbstractLoader;

/**
 * Class Loader
 */
class Loader extends AbstractLoader
{
    /**
     * @param DetailAccountInput $input
     *
     * @return string
     */
    public function load(DetailAccountInput $input)
    {
        return $this->sendDatasFormatted(
            $input->getAccountId(),
            ['groups' => 'detail_account']
        );
    }
}

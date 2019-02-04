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

use App\Entity\Account;

/**
 * Class DetailAccountOutput
 */
class DetailAccountOutput
{
    /** @var Account */
    protected $account;

    /** @var array */
    protected $operationsManual;

    /**
     * DetailAccountOutput constructor.
     *
     * @param Account $account
     * @param array   $operationsManual
     */
    public function __construct(
        Account $account,
        array $operationsManual
    ) {
        $this->account = $account;
        $this->operationsManual = $operationsManual;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @return array
     */
    public function getOperationsManual(): array
    {
        return $this->operationsManual;
    }
}

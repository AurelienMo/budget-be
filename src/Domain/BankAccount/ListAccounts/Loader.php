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

namespace App\Domain\BankAccount\ListAccounts;

use App\Domain\AbstractLoader;
use App\Domain\Common\Repository\AccountRepository;
use App\Entity\Account;

/**
 * Class Loader
 */
class Loader extends AbstractLoader
{
    /**
     * @param ListAccountsInput $input
     *
     * @return string|null
     */
    public function load(ListAccountsInput $input)
    {
        /** @var AccountRepository $repo */
        $repo = $this->getRepository(Account::class);
        $accounts = $repo->loadAccountsByUser($input->getUser());

        if (empty($accounts)) {
            return null;
        }

        return $this->sendDatasFormatted(
            $accounts,
            ['groups' => 'list_accounts']
        );
    }
}

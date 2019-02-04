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
use App\Domain\Common\Repository\OperationManualRepository;
use App\Entity\Account;
use App\Entity\OperationManual;

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
        /** @var OperationManualRepository $operationManualRepo */
        $operationManualRepo = $this->getRepository(OperationManual::class);
        $operationsManual = $operationManualRepo->loadOperationsByAccount($input->getAccountId());

        return $this->sendDatasFormatted(
            $this->buildOutput($input->getAccountId(), $operationsManual),
            ['groups' => 'detail_account']
        );
    }

    /**
     * @param Account $account
     * @param array   $opeManual
     *
     * @return DetailAccountOutput
     */
    private function buildOutput(Account $account, array $opeManual)
    {
        return new DetailAccountOutput(
            $account,
            $opeManual
        );
    }
}

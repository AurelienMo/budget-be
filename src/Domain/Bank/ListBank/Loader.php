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

namespace App\Domain\Bank\ListBank;

use App\Domain\AbstractLoader;
use App\Domain\Common\Repository\CfgBankRepository;
use App\Entity\CfgBank;

/**
 * Class Loader
 */
class Loader extends AbstractLoader
{
    /**
     * @param ListBankInput $input
     *
     * @return string|null
     */
    public function load(ListBankInput $input): ?string
    {
        /** @var CfgBankRepository $repo */
        $repo = $this->getRepository(CfgBank::class);
        $datas = $repo->loadByKeywords($input->getSearch());

        if (empty(count($datas))) {
            return null;
        }

        return $this->sendDatasFormatted(
            $datas,
            ['groups' => 'list_bank']
        );
    }
}

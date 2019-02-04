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

namespace App\Domain\Common\Repository;

use App\Entity\Account;
use Doctrine\ORM\EntityRepository;

/**
 * Class OperationManualRepository
 */
class OperationManualRepository extends EntityRepository
{
    public function loadOperationsByAccount(Account $account)
    {
        return $this->createQueryBuilder('om')
//            ->innerJoin('om.cfgCategoryOperation', 'catope', 'WITH', 'om.cfgCategoryOperation = catope.id')
//            ->innerJoin('om.cfgTypeOperation', 'typeope', 'WITH', 'om.cfgTypeOperation = typeope.id')
            ->where('om.account = :account')
            ->setParameter('account', $account)
            ->getQuery()
            ->getResult();
    }
}

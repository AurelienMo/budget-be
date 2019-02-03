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

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class AccountRepository
 */
class AccountRepository extends EntityRepository
{
    public function loadAccountsByUser(User $user)
    {
        return $this->createQueryBuilder('a')
                    ->innerJoin('a.cfgBank', 'cfgBank', 'WITH', 'a.cfgBank = cfgBank.id')
                    ->where('a.user = :user')
                    ->setParameter('user', $user)
                    ->getQuery()
                    ->getResult();
    }
}

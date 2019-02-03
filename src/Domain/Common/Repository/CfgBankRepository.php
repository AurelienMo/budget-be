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

use Doctrine\ORM\EntityRepository;

/**
 * Class CfgBankRepository
 */
class CfgBankRepository extends EntityRepository
{
    /**
     * @param string|null $keyword
     *
     * @return mixed
     */
    public function loadByKeywords(?string $keyword)
    {
        $qb = $this->createQueryBuilder('cb');

        if (!is_null($keyword)) {
            $qb
                ->where('cb.name LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}

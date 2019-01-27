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
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserRepository
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @param string $identifier
     *
     * @return mixed|UserInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername($identifier)
    {
        return $this->createQueryBuilder('u')
                    ->where('u.email = :identifier OR u.username = :identifier')
                    ->setParameter('identifier', $identifier)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @param string $tokenActivation
     *
     * @return mixed|UserInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function loadByTokenActivation(string $tokenActivation)
    {
        return $this->createQueryBuilder('u')
                    ->where('u.tokenActivation = :tokenActivation')
                    ->setParameter('tokenActivation', $tokenActivation)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}

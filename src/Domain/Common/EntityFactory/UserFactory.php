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

use App\Entity\User;

/**
 * Class UserFactory
 */
class UserFactory
{
    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $tokenActivation
     *
     * @return User
     *
     * @throws \Exception
     */
    public static function create(
        string $firstname,
        string $lastname,
        string $username,
        string $password,
        string $email,
        string $tokenActivation
    ) {
        return new User(
            $firstname,
            $lastname,
            $username,
            $password,
            $email,
            $tokenActivation
        );
    }
}

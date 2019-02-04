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

use App\Domain\InputInterface;
use App\Entity\Account;
use App\Entity\User;

/**
 * Class DetailAccountInput
 */
class DetailAccountInput implements InputInterface
{
    /**
     * @var Account
     */
    protected $accountId;

    /**
     * @var User
     */
    protected $user;

    /**
     * @return Account
     */
    public function getAccountId(): Account
    {
        return $this->accountId;
    }

    /**
     * @param Account $accountId
     *
     * @return DetailAccountInput
     */
    public function setAccountId(Account $accountId): DetailAccountInput
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return DetailAccountInput
     */
    public function setUser(User $user): DetailAccountInput
    {
        $this->user = $user;
        return $this;
    }
}

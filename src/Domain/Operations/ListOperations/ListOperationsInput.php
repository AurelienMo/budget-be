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

namespace App\Domain\Operations\ListOperations;

use App\Domain\InputInterface;
use App\Entity\Account;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ListOperationsInput
 */
class ListOperationsInput implements InputInterface
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * @var int|null
     *
     * @Assert\NotBlank(
     *     message="Ce champs est obligatoire."
     * )
     */
    protected $offset;

    /**
     * @var int|null
     *
     * @Assert\NotBlank(
     *     message="Ce champs est obligatoire."
     * )
     */
    protected $limit;

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }
}

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

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Account
 *
 * @ORM\Table(name="amo_account")
 * @ORM\Entity(repositoryClass="App\Domain\Common\Repository\AccountRepository")
 */
class Account extends AbstractEntity
{
    use NameTrait;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $initialBalance;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $balance;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $displayInGroup;

    /**
     * @var CfgBank
     *
     * @ORM\ManyToOne(targetEntity="CfgBank")
     * @ORM\JoinColumn(name="amo_cfg_bank_id", referencedColumnName="id")
     */
    protected $cfgBank;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="amo_user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Account constructor.
     *
     * @param CfgBank $cfgBank
     * @param string  $name
     * @param float   $initialBalance
     * @param User    $user
     *
     * @throws \Exception
     */
    public function __construct(
        CfgBank $cfgBank,
        string $name,
        float $initialBalance,
        User $user
    ) {
        $this->cfgBank = $cfgBank;
        $this->name = $name;
        $this->initialBalance = $initialBalance;
        $this->balance = $initialBalance;
        $this->user = $user;
        $this->displayInGroup = false;
        parent::__construct();
    }

    /**
     * @return float
     */
    public function getInitialBalance(): float
    {
        return $this->initialBalance;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @return bool
     */
    public function isDisplayInGroup(): bool
    {
        return $this->displayInGroup;
    }

    /**
     * @return CfgBank
     */
    public function getCfgBank(): CfgBank
    {
        return $this->cfgBank;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function updateBalance(float $amount)
    {
        $this->balance += $amount;
    }
}

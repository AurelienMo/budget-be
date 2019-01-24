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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractOperation
 */
abstract class AbstractOperation extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $beneficiary;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $amount;

    /**
     * @var CfgCategoryOperation
     *
     * @ORM\OneToOne(targetEntity="CfgCategoryOperation")
     * @ORM\JoinColumn(name="amo_cfg_category_operation_id", referencedColumnName="id")
     */
    protected $cfgCategoryOperation;

    /**
     * @var CfgTypeOperation
     *
     * @ORM\OneToOne(targetEntity="CfgTypeOperation")
     * @ORM\JoinColumn(name="amo_cfg_type_operation_id", referencedColumnName="id")
     */
    protected $cfgTypeOperation;

    /**
     * @var Account
     *
     * @ORM\OneToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="amo_account_id", referencedColumnName="id")
     */
    protected $account;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateOperation;

    /**
     * AbstractOperation constructor.
     *
     * @param Account              $account
     * @param CfgTypeOperation     $cfgTypeOperation
     * @param CfgCategoryOperation $cfgCategoryOperation
     * @param string               $beneficiary
     * @param float                $amount
     * @param \DateTime|null       $dateOperation
     *
     * @throws \Exception
     */
    public function __construct(
        Account $account,
        CfgTypeOperation $cfgTypeOperation,
        CfgCategoryOperation $cfgCategoryOperation,
        string $beneficiary,
        float $amount,
        \DateTime $dateOperation = null
    ) {
        $this->account = $account;
        $this->cfgTypeOperation = $cfgTypeOperation;
        $this->cfgCategoryOperation = $cfgCategoryOperation;
        $this->beneficiary = $beneficiary;
        $this->amount = $amount;
        $this->dateOperation = !is_null($dateOperation) ? $dateOperation : new \DateTime();
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getBeneficiary(): string
    {
        return $this->beneficiary;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return CfgCategoryOperation
     */
    public function getCfgCategoryOperation(): CfgCategoryOperation
    {
        return $this->cfgCategoryOperation;
    }

    /**
     * @return CfgTypeOperation
     */
    public function getCfgTypeOperation(): CfgTypeOperation
    {
        return $this->cfgTypeOperation;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @return \DateTime
     */
    public function getDateOperation(): \DateTime
    {
        return $this->dateOperation;
    }
}

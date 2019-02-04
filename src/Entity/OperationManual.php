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
 * Class OperationManual
 *
 * @ORM\Table(name="amo_operation_manual")
 * @ORM\Entity(repositoryClass="App\Domain\Common\Repository\OperationManualRepository")
 */
class OperationManual extends AbstractOperation
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $dateOperation;

    /**
     * OperationManual constructor.
     *
     * @param Account              $account
     * @param CfgTypeOperation     $cfgTypeOperation
     * @param CfgCategoryOperation $cfgCategoryOperation
     * @param string               $beneficiary
     * @param float                $amount
     * @param \DateTime            $dateOperation
     *
     * @throws \Exception
     */
    public function __construct(
        Account $account,
        CfgTypeOperation $cfgTypeOperation,
        CfgCategoryOperation $cfgCategoryOperation,
        string $beneficiary,
        float $amount,
        \DateTime $dateOperation
    ) {
        $this->dateOperation = $dateOperation;
        parent::__construct(
            $account,
            $cfgTypeOperation,
            $cfgCategoryOperation,
            $beneficiary,
            $amount
        );
    }

    /**
     * @return \DateTime
     */
    public function getDateOperation(): \DateTime
    {
        return $this->dateOperation;
    }
}

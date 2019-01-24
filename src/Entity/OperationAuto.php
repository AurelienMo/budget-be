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
 * Class OperationAuto
 *
 * @ORM\Table(name="amo_operation_auto")
 * @ORM\Entity()
 */
class OperationAuto extends AbstractOperation
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $activated;

    /**
     * OperationAuto constructor.
     *
     * @param Account              $account
     * @param CfgTypeOperation     $cfgTypeOperation
     * @param CfgCategoryOperation $cfgCategoryOperation
     * @param string               $beneficiary
     * @param float                $amount
     * @param \DateTime|null       $dateOperation
     * @param bool                 $activated
     *
     * @throws \Exception
     */
    public function __construct(
        Account $account,
        CfgTypeOperation $cfgTypeOperation,
        CfgCategoryOperation $cfgCategoryOperation,
        string $beneficiary,
        float $amount,
        ?\DateTime $dateOperation = null,
        bool $activated = false
    ) {
        $this->activated = $activated;
        parent::__construct(
            $account,
            $cfgTypeOperation,
            $cfgCategoryOperation,
            $beneficiary,
            $amount,
            $dateOperation
        );
    }

    /**
     * @return bool
     */
    public function isActivated(): bool
    {
        return $this->activated;
    }
}

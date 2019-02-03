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
 * Class CfgBank
 *
 * @ORM\Table(name="amo_cfg_bank")
 * @ORM\Entity(repositoryClass="App\Domain\Common\Repository\CfgBankRepository")
 */
class CfgBank extends AbstractCfgEntity
{
}

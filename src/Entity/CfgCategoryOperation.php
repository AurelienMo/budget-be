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
 * Class CfgCategoryOperation
 *
 * @ORM\Table(name="amo_cfg_category_operation")
 * @ORM\Entity()
 */
class CfgCategoryOperation extends AbstractCfgEntity
{
}

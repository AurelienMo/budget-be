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

use App\Domain\Common\Helpers\Slugger;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;

/**
 * Class AbstractCfgEntity
 */
abstract class AbstractCfgEntity extends AbstractEntity
{
    use NameTrait;
    use SlugTrait;

    /**
     * AbstractCfgEntity constructor.
     *
     * @param string $name
     *
     * @throws \Exception
     */
    public function __construct(
        string $name
    ) {
        $this->name = $name;
        $this->slug = Slugger::slugify($name);
        parent::__construct();
    }
}

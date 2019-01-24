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
 * Class GroupUser
 *
 * @ORM\Table(name="amo_group_user")
 * @ORM\Entity()
 */
class GroupUser extends AbstractCfgEntity
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="amo_owner_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * GroupUser constructor.
     *
     * @param string $name
     * @param User   $owner
     *
     * @throws \Exception
     */
    public function __construct(
        string $name,
        User $owner
    ) {
        $this->owner = $owner;
        parent::__construct($name);
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }
}

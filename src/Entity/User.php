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

use App\Domain\Common\Helpers\RolesList;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Table(name="amo_user")
 * @ORM\Entity(repositoryClass="App\Domain\Common\Repository\UserRepository")
 */
class User extends AbstractEntity implements UserInterface
{
    const STATUS_PENDING_ACTIVATION = 'pending_activation';
    const STATUS_ACTIVATED = 'activated';
    const STATUS_LOCK = 'locked';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tokenActivation;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tokenResetPassword;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    protected $roles;

    /**
     * @var GroupUser|null
     *
     * @ORM\ManyToOne(targetEntity="GroupUser")
     * @ORM\JoinColumn(name="amo_group_user_id", referencedColumnName="id")
     */
    protected $groupUser;

    public function __construct(
        string $firstname,
        string $lastname,
        string $username,
        string $password,
        string $email,
        string $tokenActivation,
        GroupUser $groupUser = null
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->tokenActivation = $tokenActivation;
        $this->groupUser = $groupUser;
        $this->status = self::STATUS_PENDING_ACTIVATION;
        $this->roles[] = RolesList::ROLE_USER;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getTokenActivation(): ?string
    {
        return $this->tokenActivation;
    }

    /**
     * @return string|null
     */
    public function getTokenResetPassword(): ?string
    {
        return $this->tokenResetPassword;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return GroupUser|null
     */
    public function getGroupUser(): ?GroupUser
    {
        return $this->groupUser;
    }

    public function enableUser()
    {
        $this->status = self::STATUS_ACTIVATED;
        $this->tokenActivation = null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return null;
    }
}

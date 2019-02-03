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

namespace App\Domain\BankAccount\Create;

use App\Domain\BankAccount\Validators\CfgBankNotExist;
use App\Domain\InputInterface;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PayloadNewBankAccountInput
 */
class PayloadNewBankAccountInput implements InputInterface
{
    /**
     * @var User|null
     *
     * @Assert\NotBlank(
     *     message="Un utilisateur est requis pour créer un compte."
     * )
     */
    protected $user;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Le choix de la banque est requis."
     * )
     * @CfgBankNotExist(
     *     message="La banque choisie est invalide."
     * )
     */
    protected $cfgBank;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Un nom de compte est requis."
     * )
     */
    protected $name;

    /**
     * @var float|null
     *
     * @Assert\NotBlank(
     *     message="Un solde de création de compte initial est requis."
     * )
     */
    protected $initialBalance;

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getCfgBank(): ?string
    {
        return $this->cfgBank;
    }

    /**
     * @param string|null $cfgBank
     */
    public function setCfgBank(?string $cfgBank): void
    {
        $this->cfgBank = $cfgBank;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float|null
     */
    public function getInitialBalance(): ?float
    {
        return $this->initialBalance;
    }

    /**
     * @param float|null $initialBalance
     */
    public function setInitialBalance(?float $initialBalance): void
    {
        $this->initialBalance = $initialBalance;
    }
}

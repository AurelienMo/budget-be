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

namespace App\Domain\Account\ConfirmRegistration;

use App\Domain\Account\ConfirmRegistration\Validators\InvalidEmail;
use App\Domain\Account\ConfirmRegistration\Validators\TokenNotFound;
use App\Domain\InputInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ConfirmRegistrationInput
 */
class ConfirmRegistrationInput implements InputInterface
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Une adresse email est requise."
     * )
     * @InvalidEmail(
     *     message="Merci de vérifier l'adresse email avec laquelle vous vous êtes inscrit dans votre boite mail."
     * )
     */
    protected $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Identifiant unique non trouvé."
     * )
     * @TokenNotFound(
     *     message="L'identifiant unique fourni est incorrect."
     * )
     */
    protected $token;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}

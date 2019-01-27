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

namespace App\Domain\Account\RecoveryPassword;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MailRecoveryPasswordEvent
 */
class MailRecoveryPasswordEvent extends Event
{
    const MAIL_RECOVERY_PASSWORD = 'app.mail.recovery_password';
    const TEMPLATE_MAIL = 'mails/accounts/recovery_password.html.twig';
    const SUBJECT = '[Budget Application] Demande de réinitialisation de mot de passe';

    /** @var User */
    protected $user;

    /**
     * MailRecoveryPasswordEvent constructor.
     *
     * @param User $user
     */
    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}

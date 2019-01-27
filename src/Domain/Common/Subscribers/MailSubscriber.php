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

namespace App\Domain\Common\Subscribers;

use App\Domain\Account\RecoveryPassword\MailRecoveryPasswordEvent;
use App\Domain\Account\Registration\RegistrationMailEvent;
use App\Domain\Common\Helpers\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MailSubscriber
 */
class MailSubscriber implements EventSubscriberInterface
{
    /** @var Mailer */
    protected $mailer;

    /** @var array */
    protected $paramsAppMail;

    /**
     * MailSubscriber constructor.
     *
     * @param Mailer $mailer
     * @param array  $paramsAppMail
     */
    public function __construct(
        Mailer $mailer,
        array $paramsAppMail
    ) {
        $this->mailer = $mailer;
        $this->paramsAppMail = $paramsAppMail;
    }

    public static function getSubscribedEvents()
    {
        return [
            RegistrationMailEvent::MAIL_REGISTRATION_EVENT => 'onRegistration',
            MailRecoveryPasswordEvent::MAIL_RECOVERY_PASSWORD => 'onRecoveryPassword',
        ];
    }

    /**
     * @param RegistrationMailEvent $event
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onRegistration(RegistrationMailEvent $event)
    {
        $this->mailer->sendMail(
            $this->paramsAppMail,
            [
                'email' => $event->getUser()->getEmail(),
                'name' => sprintf('%s %s', $event->getUser()->getFirstname(), $event->getUser()->getLastname()),
            ],
            RegistrationMailEvent::SUBJECT,
            RegistrationMailEvent::TEMPLATE_MAIL,
            [
                'user' => $event->getUser(),
            ]
        );
    }

    /**
     * @param MailRecoveryPasswordEvent $event
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onRecoveryPassword(MailRecoveryPasswordEvent $event)
    {
        $this->mailer->sendMail(
            $this->paramsAppMail,
            [
                'email' => $event->getUser()->getEmail(),
                'name' => sprintf('%s %s', $event->getUser()->getFirstname(), $event->getUser()->getLastname()),
            ],
            MailRecoveryPasswordEvent::SUBJECT,
            MailRecoveryPasswordEvent::TEMPLATE_MAIL,
            [
                'user' => $event->getUser(),
            ]
        );
    }
}

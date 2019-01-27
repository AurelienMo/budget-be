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

namespace App\Domain\Account\Authentication\Subscribers;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

/**
 * Class JWTExpiredListener
 */
class JWTExpiredListener
{
    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        /** @var JWTAuthenticationFailureResponse $response */
        $response = $event->getResponse();

        $response->setMessage('Votre session est expirée, merci de vous reconnecter.');
    }
}

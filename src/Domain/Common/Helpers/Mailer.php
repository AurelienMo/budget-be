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

namespace App\Domain\Common\Helpers;

use Twig\Environment;

/**
 * Class Mailer
 */
class Mailer
{
    /** @var \Swift_Mailer */
    protected $swiftMailer;

    /** @var Environment */
    protected $templating;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $swiftMailer
     * @param Environment   $templating
     */
    public function __construct(
        \Swift_Mailer $swiftMailer,
        Environment $templating
    ) {
        $this->swiftMailer = $swiftMailer;
        $this->templating = $templating;
    }

    /**
     * @param array  $from
     * @param array  $to
     * @param string $subject
     * @param string $template
     * @param array  $paramsTemplate
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMail(
        array $from,
        array $to,
        string $subject,
        string $template,
        array $paramsTemplate
    ) {
        $message = new \Swift_Message();
        $message
            ->setSubject($subject)
            ->setFrom($from['email'], $from['name'])
            ->setTo($to['email'], $to['name'])
            ->setBody(
                $this->templating->render(
                    $template,
                    $paramsTemplate
                ),
                'text/html'
            );

        $this->swiftMailer->send($message);
    }
}

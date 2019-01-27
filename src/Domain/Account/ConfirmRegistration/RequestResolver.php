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

use App\Domain\AbstractRequestResolver;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Domain\Common\Helpers\RequestParamsExtractor;
use App\Domain\InputInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestResolver
 */
class RequestResolver extends AbstractRequestResolver
{
    const QUERY_PARAM_TOKEN_ACTIVATION = 'tokenActivation';

    /**
     * @param Request $request
     *
     * @return InputInterface|ConfirmRegistrationInput|null
     *
     * @throws ValidatorException
     */
    public function resolve(Request $request): ?InputInterface
    {
        /** @var ConfirmRegistrationInput $input */
        $input = $this->getInputFromPayload($request);
        $input->setToken(
            RequestParamsExtractor::extractParams(
                $request,
                RequestParamsExtractor::QUERY,
                self::QUERY_PARAM_TOKEN_ACTIVATION
            )
        );
        $this->validate($input);

        return $input;
    }

    /**
     * @return string
     */
    protected function getInputClassName(): string
    {
        return ConfirmRegistrationInput::class;
    }
}
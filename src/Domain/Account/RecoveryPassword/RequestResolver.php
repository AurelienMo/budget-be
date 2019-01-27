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

use App\Domain\AbstractRequestResolver;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Domain\InputInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestResolver
 */
class RequestResolver extends AbstractRequestResolver
{
    /**
     * @param Request $request
     *
     * @return InputInterface|RecoveryPasswordInput|null
     * @throws ValidatorException
     */
    public function resolve(Request $request): ?InputInterface
    {
        /** @var RecoveryPasswordInput $input */
        $input = $this->getInputFromPayload($request);
        $this->validate($input);

        return $input;
    }

    /**
     * @return string
     */
    protected function getInputClassName(): string
    {
        return RecoveryPasswordInput::class;
    }
}
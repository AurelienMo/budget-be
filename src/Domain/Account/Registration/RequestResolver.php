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

namespace App\Domain\Account\Registration;

use App\Domain\AbstractRequestResolver;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Domain\InputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RequestResolver
 */
class RequestResolver extends AbstractRequestResolver
{
    /**
     * @param Request $request
     *
     * @return InputInterface|RegistrationInput|null
     *
     * @throws ValidatorException
     */
    public function resolve(Request $request): ?InputInterface
    {
        if (!is_null($this->getCurrentUser())) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                'Vous ne pouvez pas vous inscrire en étant déjà connecté.'
            );
        }
        /** @var RegistrationInput $input */
        $input = $this->getInputFromPayload($request);
        $this->validate($input);

        return $input;
    }

    protected function getInputClassName(): string
    {
        return RegistrationInput::class;
    }
}

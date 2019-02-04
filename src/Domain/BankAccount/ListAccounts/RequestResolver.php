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

namespace App\Domain\BankAccount\ListAccounts;

use App\Domain\AbstractRequestResolver;
use App\Domain\InputInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestResolver
 */
class RequestResolver extends AbstractRequestResolver
{
    /**
     * @param Request $request
     *
     * @return InputInterface|ListAccountsInput|null
     *
     * @throws \ReflectionException
     */
    public function resolve(Request $request): ?InputInterface
    {
        /** @var ListAccountsInput $input */
        $input = $this->intanciateInputClass();
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $input->setUser($user);

        return $input;
    }

    /**
     * @return string
     */
    protected function getInputClassName(): string
    {
        return ListAccountsInput::class;
    }
}

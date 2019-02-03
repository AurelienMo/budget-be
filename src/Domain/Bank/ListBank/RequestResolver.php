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

namespace App\Domain\Bank\ListBank;

use App\Domain\AbstractRequestResolver;
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
     * @return InputInterface|ListBankInput|null
     *
     * @throws \ReflectionException
     */
    public function resolve(Request $request): ?InputInterface
    {
        /** @var ListBankInput $input */
        $input = $this->intanciateInputClass();
        $input->setSearch($request->query->get('search') ?? null);

        return $input;
    }

    /**
     * @return string
     */
    protected function getInputClassName(): string
    {
        return ListBankInput::class;
    }
}

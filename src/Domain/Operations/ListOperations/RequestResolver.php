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

namespace App\Domain\Operations\ListOperations;

use App\Domain\AbstractRequestResolver;
use App\Domain\Common\Exceptions\ProcessorErrorsHttp;
use App\Domain\Common\Repository\AccountRepository;
use App\Domain\InputInterface;
use App\Entity\Account;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestResolver
 */
class RequestResolver extends AbstractRequestResolver
{
    /**
     * @param Request $request
     *
     * @return InputInterface|ListOperationsInput|null
     * @throws NonUniqueResultException
     * @throws \ReflectionException
     */
    public function resolve(Request $request): ?InputInterface
    {
        /** @var AccountRepository $accountRepo */
        $accountRepo= $this->getRepository(Account::class);
        $account = $accountRepo->loadById($request->attributes->get('id') ?? null);
        if (\is_null($account)) {
            ProcessorErrorsHttp::throwNotFound(
                sprintf('Ce compte n\'existe pas.')
            );
        }
        /** @var ListOperationsInput $input */
        $input = $this->intanciateInputClass();
    }

    /**
     * @return string
     */
    protected function getInputClassName(): string
    {
        return ListOperationsInput::class;
    }
}

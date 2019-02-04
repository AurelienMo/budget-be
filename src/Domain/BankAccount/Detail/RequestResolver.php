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

namespace App\Domain\BankAccount\Detail;

use App\Domain\AbstractRequestResolver;
use App\Domain\Common\Exceptions\ProcessorErrorsHttp;
use App\Domain\Common\Repository\AccountRepository;
use App\Domain\InputInterface;
use App\Entity\Account;
use App\Entity\User;
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
     * @return InputInterface|DetailAccountInput|null
     *
     * @throws NonUniqueResultException
     * @throws \ReflectionException
     */
    public function resolve(Request $request): ?InputInterface
    {
        /** @var AccountRepository $repo */
        $repo = $this->getRepository(Account::class);
        /** @var Account|null $account */
        $account = $repo->loadById($request->attributes->get('id') ?? null);

        if (\is_null($account)) {
            ProcessorErrorsHttp::throwNotFound("Ce compte n'existe pas.");
        }

        if (!$this->authorizationChecker->isGranted('accessOwnerGroupMember', $account)) {
            ProcessorErrorsHttp::throwAccessDenied(
                'Vous n\'avez pas les droits pour accéder à ce compte.'
            );
        }

        if (!$this->authorizationChecker->isGranted('sharedAccount', $account)) {
            ProcessorErrorsHttp::throwAccessDenied(
                'Le compte de la personne de ce groupe n\'est pas partagé.'
            );
        }
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        /** @var DetailAccountInput $input */
        $input = $this->intanciateInputClass();
        $input->setUser($user)
              ->setAccountId($account);

        return $input;
    }

    /**
     * @return string
     */
    protected function getInputClassName(): string
    {
        return DetailAccountInput::class;
    }
}

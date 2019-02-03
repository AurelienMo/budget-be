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

namespace App\Domain\BankAccount\Create;

use App\Domain\AbstractPersister;
use App\Domain\Common\EntityFactory\BankAccountFactory;
use App\Domain\Common\Repository\AccountRepository;
use App\Domain\Common\Repository\CfgBankRepository;
use App\Domain\InputInterface;
use App\Entity\Account;
use App\Entity\CfgBank;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /**
     * @param InputInterface|PayloadNewBankAccountInput|null $input
     *
     * @return string|null
     *
     * @throws \Exception
     */
    public function save(?InputInterface $input = null): ?string
    {
        /** @var PayloadNewBankAccountInput $paylodInput */
        $paylodInput = $input;
        /** @var CfgBankRepository $repoBank */
        $repoBank = $this->entityManager->getRepository(CfgBank::class);
        $account = BankAccountFactory::create(
            $repoBank->loadBySlug($paylodInput->getCfgBank()),
            $paylodInput->getName(),
            $paylodInput->getInitialBalance(),
            $paylodInput->getUser()
        );
        $this->persistSave($account);

        /** @var AccountRepository $repoAccount */
        $repoAccount = $this->entityManager->getRepository(Account::class);
        $listAccounts = $repoAccount->loadAccountsByUser($paylodInput->getUser());

        return $this->serializer->serialize(
            $listAccounts,
            'json',
            [
                'groups' => 'list_accounts',
            ]
        );
    }

    /**
     * @return string
     */
    protected function getClassEntityName(): string
    {
        return Account::class;
    }
}

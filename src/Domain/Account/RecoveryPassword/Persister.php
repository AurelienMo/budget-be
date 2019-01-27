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

use App\Domain\AbstractPersister;
use App\Domain\Common\Helpers\TokenGenerator;
use App\Domain\Common\Repository\UserRepository;
use App\Domain\InputInterface;
use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /**
     * @param InputInterface|RecoveryPasswordInput|null $input
     *
     * @return string|null
     *
     * @throws NonUniqueResultException
     */
    public function save(?InputInterface $input = null): ?string
    {
        /** @var RecoveryPasswordInput $recoveryInput */
        $recoveryInput = $input;
        /** @var UserRepository $repo */
        $repo = $this->entityManager->getRepository(User::class);
        /** @var User|null $user */
        $user = $repo->loadUserByUsername($recoveryInput->getEmail());
        if (!is_null($user)) {
            $user->reinitPassword(TokenGenerator::generateToken());
            $this->persistSave();
            $this->eventDispatcher->dispatch(
                MailRecoveryPasswordEvent::MAIL_RECOVERY_PASSWORD,
                new MailRecoveryPasswordEvent($user)
            );
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getClassEntityName(): string
    {
        return User::class;
    }
}

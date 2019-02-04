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

namespace App\Domain\BankAccount\Voters;

use App\Entity\Account;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AccountVoter
 */
class AccountVoter extends Voter
{
    const LIST_ATTRIBUTES = [
        'accessOwnerGroupMember',
        'sharedAccount'
    ];

    /**
     * @param string $attribute
     * @param mixed  $subject
     *
     * @return bool
     */
    protected function supports(
        $attribute,
        $subject
    ) {
        if (!in_array($attribute, self::LIST_ATTRIBUTES)) {
            return false;
        }
        if (!$subject instanceof Account) {
            return false;
        }

        return true;
    }

    /**
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute(
        $attribute,
        $subject,
        TokenInterface $token
    ) {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        return $this->{'can'.ucfirst($attribute)}($subject, $user);
    }

    /**
     * @param Account $account
     * @param User    $user
     *
     * @return bool
     */
    private function canAccessOwnerGroupMember(Account $account, User $user)
    {
        if ($account->getUser() !== $user) {
            if (!\is_null($account->getUser()->getGroupUser()) && !is_null($user->getGroupUser())) {
                return $account->getUser()->getGroupUser() === $user->getGroupUser();
            }
            return false;
        }

        return true;
    }

    /**
     * @param Account $account
     * @param User    $user
     *
     * @return bool
     */
    private function canSharedAccount(Account $account, User $user)
    {
        if ($account->getUser() !== $user &&
            $account->getUser()->getGroupUser() === $user->getGroupUser() &&
            !$account->isDisplayInGroup()
        ) {
            return false;
        }

        return true;
    }
}

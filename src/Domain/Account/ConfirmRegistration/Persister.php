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

use App\Domain\AbstractPersister;
use App\Domain\Common\Repository\UserRepository;
use App\Domain\InputInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /** @var JWTTokenManagerInterface */
    protected $jwtManager;

    /**
     * Persister constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param SerializerInterface      $serializer
     * @param EventDispatcherInterface $eventDispatcher
     * @param JWTTokenManagerInterface $jwtManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        EventDispatcherInterface $eventDispatcher,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->jwtManager = $jwtManager;
        parent::__construct(
            $entityManager,
            $serializer,
            $eventDispatcher
        );
    }

    /**
     * @param InputInterface|ConfirmRegistrationInput|null $input
     *
     * @return string|null
     *
     * @throws NonUniqueResultException
     */
    public function save(?InputInterface $input = null): ?string
    {
        /** @var ConfirmRegistrationInput $registrationInput */
        $registrationInput = $input;
        /** @var UserRepository $repo */
        $repo = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $repo->loadUserByUsername($registrationInput->getEmail());
        $user->enableUser();
        $this->persistSave();

        return $this->buildOutput($user);
    }

    protected function getClassEntityName(): string
    {
        return User::class;
    }

    /**
     * @param User $user
     *
     * @return string|null
     */
    private function buildOutput(User $user)
    {
        /** @var string|null $datas */
        $datas = json_encode(
            [
                'token' => $this->jwtManager->create($user),
                'user' => [
                    'firstname' => $user->getFirstname(),
                    'lastname' => $user->getLastname(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles(),
                ],
            ]
        );

        return $datas;
    }
}

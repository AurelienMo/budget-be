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

namespace App\Domain\Account\ResetPassword;

use App\Domain\AbstractPersister;
use App\Domain\Common\Repository\UserRepository;
use App\Domain\InputInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /** @var JWTTokenManagerInterface */
    protected $jwtManager;

    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    /**
     * Persister constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param SerializerInterface      $serializer
     * @param EventDispatcherInterface $eventDispatcher
     * @param JWTTokenManagerInterface $jwtManager
     * @param EncoderFactoryInterface  $encoderFactory
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        EventDispatcherInterface $eventDispatcher,
        JWTTokenManagerInterface $jwtManager,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->jwtManager = $jwtManager;
        $this->encoderFactory = $encoderFactory;
        parent::__construct(
            $entityManager,
            $serializer,
            $eventDispatcher
        );
    }

    /**
     * @param InputInterface|ResetPasswordInput|null $input
     *
     * @return string|null
     *
     * @throws NonUniqueResultException
     */
    public function save(?InputInterface $input = null): ?string
    {
        /** @var ResetPasswordInput $resetPwInput */
        $resetPwInput = $input;
        /** @var UserRepository $repo */
        $repo = $this->entityManager->getRepository($this->getClassEntityName());
        /** @var User $user */
        $user = $repo->loadUserByUsername($resetPwInput->getEmail());
        $user->defineNewPassword(
            $this->getEncoder()->encodePassword($resetPwInput->getPassword(), '')
        );
        $this->persistSave();

        return $this->buildOutput($user);
    }

    /**
     * @return string
     */
    protected function getClassEntityName(): string
    {
        return User::class;
    }

    /**
     * @return PasswordEncoderInterface
     */
    private function getEncoder()
    {
        return $this->encoderFactory->getEncoder($this->getClassEntityName());
    }

    /**
     * @param User $user
     *
     * @return string|null
     */
    private function buildOutput(User $user)
    {
        $group = !is_null($user->getGroupUser()) ? $user->getGroupUser() : null;
        $userDatas = [
            'token' => $this->jwtManager->create($user),
            'user' => [
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ],
        ];
        if (!is_null($group)) {
            $userDatas = array_merge(
                $userDatas,
                [
                    'group' => [
                        'name' => $group->getName(),
                        'slug' => $group->getSlug(),
                        'owner' => sprintf(
                            '%s %s',
                            $group->getOwner()->getFirstname(),
                            $group->getOwner()->getLastname()
                        ),
                    ]
                ]
            );
        }
        /** @var string|null $datas */
        $datas = json_encode(
            $userDatas
        );

        return $datas;
    }
}

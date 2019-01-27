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

use App\Domain\AbstractPersister;
use App\Domain\Common\EntityFactory\UserFactory;
use App\Domain\Common\Helpers\TokenGenerator;
use App\Domain\InputInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class Persister
 */
class Persister extends AbstractPersister
{
    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        EventDispatcherInterface $eventDispatcher,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
        parent::__construct(
            $entityManager,
            $serializer,
            $eventDispatcher
        );
    }

    /**
     * @param InputInterface|RegistrationInput|null $input
     *
     * @return string|null
     * @throws \Exception
     */
    public function save(?InputInterface $input = null): ?string
    {
        $user = UserFactory::create(
            $input->getFirstname(),
            $input->getLastname(),
            $input->getUsername(),
            $this->getEncoder()->encodePassword($input->getPassword(), ''),
            $input->getEmail(),
            TokenGenerator::generateToken()
        );
        try {
            $this->persistSave($user);
        } catch (\Exception $e) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }

        //TODO Dispatch mail event

        return null;
    }

    /**
     * @return string
     */
    protected function getClassEntityName(): string
    {
        return User::class;
    }

    private function getEncoder()
    {
        return $this->encoderFactory->getEncoder($this->getClassEntityName());
    }
}

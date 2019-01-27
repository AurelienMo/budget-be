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

namespace App\Domain;

use App\Domain\Common\EntityFactory\ErrorsFactory;
use App\Domain\Common\Exceptions\ProcessorErrorsHttp;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Entity\AbstractEntity;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractRequestResolver
 */
abstract class AbstractRequestResolver
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /**
     * AbstractRequestResolver constructor.
     *
     * @param SerializerInterface           $serializer
     * @param ValidatorInterface            $validator
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param EntityManagerInterface        $entityManager
     * @param TokenStorageInterface         $tokenStorage
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        AuthorizationCheckerInterface $authorizationChecker,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     *
     * @return InputInterface|null
     */
    abstract public function resolve(Request $request): ?InputInterface;

    /**
     * @return string
     */
    abstract protected function getInputClassName(): string;

    /**
     * @param InputInterface $input
     *
     * @throws ValidatorException
     */
    protected function validate(InputInterface $input)
    {
        $constraintList = $this->validator->validate($input);

        if (count($constraintList) > 0) {
            ErrorsFactory::buildErrors($constraintList);
        }
    }

    /**
     * @param string              $attr
     * @param string              $errorMessage
     * @param AbstractEntity|null $entity
     */
    protected function checkAuthorization(string $attr, string $errorMessage, AbstractEntity $entity = null)
    {
        if (!$this->authorizationChecker->isGranted($attr, $entity)) {
            ProcessorErrorsHttp::throwAccessDenied($errorMessage);
        }
    }

    /**
     * @param string $className
     *
     * @return ObjectRepository
     */
    protected function getRepository(string $className)
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * @param Request $request
     *
     * @return object
     */
    protected function getInputFromPayload(Request $request)
    {
        return $this->serializer->deserialize($request->getContent(), $this->getInputClassName(), 'json');
    }

    /**
     * @return InputInterface
     *
     * @throws ReflectionException
     */
    protected function intanciateInputClass()
    {
        $reflectClass = new \ReflectionClass($this->getInputClassName());
        $class = $reflectClass->name;

        return new $class();
    }

    /**
     * @return string|UserInterface|null
     */
    protected function getCurrentUser()
    {
        /** @var TokenInterface|null $token */
        $token = $this->tokenStorage->getToken();
        if (!is_null($token)) {
            /** @var UserInterface|string $user */
            $user = $token->getUser();
            if ($user instanceof UserInterface) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}

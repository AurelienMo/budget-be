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

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractLoader
 */
abstract class AbstractLoader
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /**
     * AbstractLoader constructor.
     *
     * @param EntityManagerInterface        $entityManager
     * @param SerializerInterface           $serializer
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param string $className
     *
     * @return ObjectRepository
     */
    protected function getRepository(string $className): ObjectRepository
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * @param mixed $datas
     * @param array $context
     *
     * @return string
     */
    protected function sendDatasFormatted($datas, array $context = [])
    {
        return $this->serializer->serialize(
            $datas,
            'json',
            $context
        );
    }
}

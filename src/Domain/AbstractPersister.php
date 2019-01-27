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

use App\Entity\AbstractEntity;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractPersister
 */
abstract class AbstractPersister
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * AbstractPersister constructor.
     *
     * @param EntityManagerInterface   $entityManager
     * @param SerializerInterface      $serializer
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param InputInterface|null $input
     *
     * @return string|null
     */
    abstract public function save(?InputInterface $input = null): ?string;

    /**
     * @param string|null $className
     *
     * @return ObjectRepository
     */
    protected function getRepository(string $className = null)
    {
        return $this->getRepository($className ?? $this->getClassEntityName());
    }

    /**
     * @param AbstractEntity|null $entity
     */
    protected function persistSave(AbstractEntity $entity = null)
    {
        if (!is_null($entity)) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }

    /**
     * @return string
     */
    abstract protected function getClassEntityName(): string;
}

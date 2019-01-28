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

namespace App\Domain\ProdDatas;

use Doctrine\ORM\EntityManagerInterface;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadProdDatasCommand
 */
class LoadProdDatasCommand extends Command
{
    const PROD_ENTRY_POINT = __DIR__.'/datas/00_load.yml';

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * LoadProdDatasCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param string|null            $name
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ?string $name = null
    ) {
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }

    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('app:load-prod-fixtures')
            ->setDescription('Load production fixtures');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $objectSet = $this->getNativeLoader()->loadFile(self::PROD_ENTRY_POINT);
        foreach ($objectSet->getObjects() as $object) {
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }

    private function getNativeLoader()
    {
        return new NativeLoader();
    }
}

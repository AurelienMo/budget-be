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

namespace App\Domain\Account\NewAccountFromCommand;

use App\Domain\Common\EntityFactory\UserFactory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class CreateAccountFromCommand
 */
class CreateAccountFromCommand extends Command
{
    const LIST_FIELDS = [
        'firstname' => null,
        'lastname' => null,
        'username' => null,
        'password' => null,
        'email' => null,
    ];

    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * CreateAccountFromCommand constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param EntityManagerInterface  $entityManager
     * @param string|null             $name
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        EntityManagerInterface $entityManager,
        ?string $name = null
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('app:create-account')
            ->setDescription('Create account from command line');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws \Exception
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $listFields = self::LIST_FIELDS;
        foreach (self::LIST_FIELDS as $fieldName => $field) {
            $question = new Question(sprintf('Please choose a value for %s : ', $fieldName));
            $listFields[$fieldName] = $this->getQuestionHelper()->ask($input, $output, $question);
        }
        $user = UserFactory::create(
            $listFields['firstname'],
            $listFields['lastname'],
            $listFields['username'],
            $this->getEncoder()->encodePassword($listFields['password'], ''),
            $listFields['email'],
            'FakeTokenActivation'
        );
        $user->enableUser();
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @return PasswordEncoderInterface
     */
    private function getEncoder()
    {
        return $this->encoderFactory->getEncoder(User::class);
    }

    private function getQuestionHelper()
    {
        return $this->getHelper('question');
    }
}

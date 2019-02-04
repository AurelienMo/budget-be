<?php

declare(strict_types=1);

/*
 * This file is part of Budget-be
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Domain\Common\EntityFactory\BankAccountFactory;
use App\Domain\Common\EntityFactory\UserFactory;
use App\Entity\AbstractEntity;
use App\Entity\Account;
use App\Entity\CfgBank;
use App\Entity\CfgCategoryOperation;
use App\Entity\CfgTypeOperation;
use App\Entity\GroupUser;
use App\Entity\OperationAuto;
use App\Entity\OperationManual;
use App\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class DoctrineContext
 */
class DoctrineContext implements Context
{
    /** @var SchemaTool */
    private $schemaTool;

    /** @var RegistryInterface */
    private $doctrine;

    /** @var KernelInterface */
    private $kernel;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    /**
     * DoctrineContext constructor.
     *
     * @param RegistryInterface            $doctrine
     * @param KernelInterface              $kernel
     * @param EncoderFactoryInterface      $encoderFactory
     */
    public function __construct(
        RegistryInterface $doctrine,
        KernelInterface $kernel,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->doctrine = $doctrine;
        $this->schemaTool = new SchemaTool($this->doctrine->getManager());
        $this->kernel = $kernel;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @BeforeScenario
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function clearDatabase()
    {
        $this->schemaTool->dropSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
        $this->schemaTool->createSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @Given I load following users:
     */
    public function iLoadFollowingUsers(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $user = UserFactory::create(
                $hash['firstname'],
                $hash['lastname'],
                $hash['username'],
                $this->getEncoder(User::class)->encodePassword($hash['password'], ''),
                $hash['email'],
                $hash['tokenActivation']
            );
            $this->getManager()->persist($user);
        }

        $this->getManager()->flush();
    }

    /**
     * @param string $classEncoder
     *
     * @return PasswordEncoderInterface
     */
    private function getEncoder(string $classEncoder)
    {
        return $this->encoderFactory->getEncoder($classEncoder);
    }

    /**
     * @Given I enable user :identifier
     *
     * @throws NonUniqueResultException
     */
    public function iEnableUser($identifier)
    {
        /** @var User $user */
        $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier);
        $user->enableUser();
    }

    /**
     * @Then user :identifier should exist into database
     *
     * @throws NonUniqueResultException
     */
    public function userShouldExistIntoDatabase($identifier)
    {
        $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier);

        if (!$user) {
            throw new Exception(sprintf('User with identifier %s should exist', $identifier));
        }
    }

    /**
     * @Then user :identifier should have status :status
     *
     * @throws NonUniqueResultException
     */
    public function userShouldHaveStatus($identifier, $status)
    {
        /** @var User $user */
        $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier);

        if ($user->getStatus() !== $status) {
            throw new Exception(
                sprintf(
                    'User should be have status %s, %s occured',
                    $status, $user->getStatus()
                )
            );
        }
    }

    /**
     * @Then user :identifier should have a tokenResetPassword
     *
     * @throws NonUniqueResultException
     */
    public function userShouldHaveATokenresetpassword($identifier)
    {
        /** @var User $user */
        $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier);

        if (is_null($user->getTokenResetPassword())) {
            throw new Exception('User should have a token reset password');
        }
    }

    /**
     * @Given I reinit password for user :identifier with token :tokenResetPassword
     *
     * @throws NonUniqueResultException
     */
    public function iReinitPasswordForUserWithToken(string $identifier, string $tokenResetPassword)
    {
        /** @var User $user */
        $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier);
        $user->reinitPassword($tokenResetPassword);
        $this->getManager()->flush();
    }

    /**
     * @Given I load production file
     */
    public function iLoadProductionFile()
    {
        $app = new Application($this->kernel);
        $app->setAutoExit(false);
        $input = new ArrayInput(
            [
                'command' => 'app:load-prod-fixtures',
            ]
        );
        $output = new BufferedOutput();
        $app->run($input, $output);
    }

    /**
     * @Then user :identifier should have a bank account with name :nameBankAccount
     *
     * @throws NonUniqueResultException
     */
    public function userShouldHaveABankAccountWithName($identifier, $nameBankAccount)
    {
        $account = $this->getManager()->getRepository(Account::class)
                                      ->findOneBy(
                                          [
                                              'user' => $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier),
                                              'name' => $nameBankAccount,
                                          ]
                                      );

        if (!$account) {
            throw new Exception(
                sprintf("User '%s' should have an account with name '%s'", $identifier, $nameBankAccount)
            );
        }
    }

    /**
     * @Then balance for account :nameBankAccount for user :identifier should be equal to :balance
     *
     * @throws NonUniqueResultException
     */
    public function balanceForAccountForUserShouldBeEqualTo($nameBankAccount, $identifier, $balance)
    {
        $account = $this->getManager()->getRepository(Account::class)
            ->findOneBy(
                [
                    'user' => $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier),
                    'name' => $nameBankAccount,
                ]
            );

        if ($account->getInitialBalance() !== (float) $balance) {
            throw new Exception(
                sprintf(
                    "Account '%s' for user '%s' should have initial balance equal to '%s'",
                    $nameBankAccount,
                    $identifier,
                    $balance
                )
            );
        }
    }

    /**
     * @Given users has following bank accounts:
     *
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws Exception
     */
    public function usersHasFollowingBankAccounts(TableNode $userAccounts)
    {
        foreach ($userAccounts->getHash() as $hash) {
            $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($hash['user']);
            $bank = $this->getManager()->getRepository(CfgBank::class)->loadBySlug($hash['bank']);
            $account = BankAccountFactory::create($bank, $hash['name'], (float) $hash['initialBalance'], $user);
            $this->getManager()->persist($account);
        }
        $this->getManager()->flush();
    }

    /**
     * @Given account with name :accountName should have following id :identifier
     *
     * @throws ReflectionException
     */
    public function accountWithNameShouldHaveFollowingId($accountName, $identfier)
    {
        $account = $this->getManager()->getRepository(Account::class)->findOneBy(['name' => $accountName]);
        $this->setUuid($account, $identfier);
        $this->getManager()->flush();
    }

    /**
     * @Given user :identifier should created following group:
     *
     * @throws Exception
     */
    public function userShouldCreatedFollowingGroup($identifier, TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            /** @var User $user */
            $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($identifier);
            $group = new GroupUser(
                $hash['name'],
                $user
            );
            $this->getManager()->persist($group);
            $user->defineGroup($group);
        }
        $this->getManager()->flush();
    }

    /**
     * @Given users have following group:
     *
     * @throws NonUniqueResultException
     */
    public function usersHaveFollowingGroup(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            /** @var User $user */
            $user = $this->getManager()->getRepository(User::class)->loadUserByUsername($hash['username']);
            $group = $this->getManager()->getRepository(GroupUser::class)->findOneBy(['slug' => $hash['slugGroup']]);
            $user
                ->defineGroup($group);
        }
        $this->getManager()->flush();
    }

    /**
     * @Given following operations manual has been added to account with name :name:
     *
     * @throws Exception
     */
    public function followingOperationsManualHasBeenAddedToAccountWithId($name, TableNode $table)
    {
        $account = $this->getManager()->getRepository(Account::class)->findOneBy(['name' => $name]);
        foreach ($table->getHash() as $hash) {
            $opeManual = new OperationManual(
                $account,
                $this->getManager()->getRepository(CfgTypeOperation::class)->findOneBy(['slug' => $hash['cfgTypeOperation']]),
                $this->getManager()->getRepository(CfgCategoryOperation::class)->findOneBy(['slug' => $hash['cfgCategoryOperation']]),
                $hash['beneficiary'],
                (float) $hash['amount'],
                \DateTime::createFromFormat('d/m/Y', $hash['dateOperation'])
            );
            $account->updateBalance((float) $hash['amount']);
            $this->getManager()->persist($opeManual);
        }
        $this->getManager()->flush();
    }

    /**
     * @param AbstractEntity $entity
     * @param string         $uuid
     *
     * @throws ReflectionException
     */
    private function setUuid(AbstractEntity $entity, string $uuid)
    {
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $uuid);
    }
}

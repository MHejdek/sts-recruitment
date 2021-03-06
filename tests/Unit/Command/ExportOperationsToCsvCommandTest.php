<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command;

use App\Command\ExportOperationsToCsvCommand;
use App\Entity\Operation;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Service\OperationCollectionExporter;
use App\Service\OperationCollectionMapper;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

class ExportOperationsToCsvCommandTest extends KernelTestCase
{
    protected function setUp(): void
    {
        // create wallet
        $wallet = new Wallet();

        // create operation and add it to wallet
        $operation = $this->createMock(Operation::class);
        $operation->method('getId')->willReturn(2);
        $operation->method('getType')->willReturn('substraction');
        $operation->method('getAmount')->willReturn(321);
        $wallet->addOperation($operation);

        // mock filesystem to dump to file
        $filesystemMock = $this->createMock(Filesystem::class);

        // initiate operationCollectionMapper service which maps Operation Collection to csv string
        $operationCollectionMapper = new OperationCollectionMapper();

        // initiate operationCollectionExporter service which runs an export in method exportToCsv()
        $operationCollectionExporter = new OperationCollectionExporter($filesystemMock, $operationCollectionMapper);

        // mock the wallet repository so it will return a wallet created above
        $walletRepositoryMock = $this->createMock(WalletRepository::class);
        $walletRepositoryMock->method('find')->with(1)->willReturn($wallet);

        // define some basic test command setup
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(new ExportOperationsToCsvCommand($operationCollectionExporter, $walletRepositoryMock));
        $command = $application->find('app:export-csv');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteSuccessful(): void
    {
        // execute command
        $this->commandTester->execute(['walletId' => '1']);
        $this->commandTester->assertCommandIsSuccessful();
    }

}
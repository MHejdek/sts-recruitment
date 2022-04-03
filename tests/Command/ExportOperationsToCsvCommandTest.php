<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\ExportOperationsToCsvCommand;
use App\Entity\Operation;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Service\FileExporter;
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

        // mock the wallet repository so it will return a wallet created above
        $walletRepositoryMock = $this->createMock(WalletRepository::class);
        $walletRepositoryMock->method('find')->with()->willReturn($wallet);

        // mock filesystem to dump to file
        $filesystem = $this->createMock(Filesystem::class);

        // initiate FileExporter service which runs an export in method exportOperations()
        $fileExporter = new FileExporter($walletRepositoryMock, $filesystem);

        // define some basic test command setup
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(new ExportOperationsToCsvCommand($fileExporter));
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
<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\WalletRepository;
use App\Service\FileExporter;
use App\Service\OperationCollectionExporter;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:export-operations-to-csv',
    description: 'Exports operations to csv file.',
    aliases: ['app:export-csv'],
    hidden: false
)]
class ExportOperationsToCsvCommand extends Command
{
    public function __construct(
        private OperationCollectionExporter $operationExporter,
        private WalletRepository $walletRepository,
        string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command exports operations to csv file.')
            ->addArgument('walletId', InputArgument::REQUIRED, 'Wallet id needed for operations export');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $operationCollection = $this->getOperationCollection((int)$input->getArgument('walletId'));
            $this->operationExporter->exportToCsv($operationCollection);
        } catch (\Exception $exception) {
            $output->writeln('-------------------------------------');
            $output->writeln('EXPORT FAILED.');
            $output->writeln('-------------------------------------');
            $output->writeln($exception->getMessage());
            $output->writeln('-------------------------------------');

            return Command::FAILURE;
        }
        $output->writeln('-------------------------------------');
        $output->writeln('EXPORT PASSED!');
        $output->writeln('-------------------------------------');
        $output->writeln('The file was exported to: /var/www/file.csv');
        $output->writeln('-------------------------------------');

        return Command::SUCCESS;
    }

    private function getOperationCollection(int $walletId): Collection
    {
        $wallet = $this->walletRepository->find($walletId);

        if (!$wallet) throw new \Exception(sprintf('No wallet found for given id: %d', $walletId));

        $operations = $wallet->getOperations();

        if ($operations->isEmpty())
            throw new \Exception(sprintf('There are not any operations for given wallet id: %d', $walletId));

        return $operations;
    }

}
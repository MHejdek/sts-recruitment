<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\FileExporter;
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
    public function __construct(private FileExporter $exportService, string $name = null)
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
        $output->writeln('-------------------------------------');
        $output->writeln('Please answer the following: ');
        $output->writeln('-------------------------------------');

        try {
            $this->exportService->exportOperations($input->getArgument('walletId'));
        } catch (\Exception $exception) {
            $output->writeln('EXPORT FAILED.');
            $output->writeln('-------------------------------------');
            $output->writeln($exception->getMessage());
            $output->writeln('-------------------------------------');

            return Command::FAILURE;
        }
        $output->writeln('EXPORT PASSED!');
        $output->writeln('-------------------------------------');
        $output->writeln('The file was exported to: /var/www/file.csv');
        $output->writeln('-------------------------------------');

        return Command::SUCCESS;
    }

}
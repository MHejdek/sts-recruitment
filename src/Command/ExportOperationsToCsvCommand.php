<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\FileExporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:export-operations-to-csv',
    description: 'Exports operations to csv file.',
    aliases: ['app:-export-csv'],
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
        $this->setHelp('This command exports operations to csv file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('-------------------------------------');
        $output->writeln('Please answer the following: ');
        $output->writeln('-------------------------------------');

        // add questions for user to answer
        $helper = $this->getHelper('question');
        $pathQuestion = new Question('File path [default: /var/www/file.csv]: ', '/var/www/file.csv');
        $walletQuestion = new Question('Wallet id: ');

        // get values from user input
        $path = $helper->ask($input, $output, $pathQuestion);
        $walletId = $helper->ask($input, $output, $walletQuestion);

        $output->writeln('-------------------------------------');

        try {
            $this->exportService->exportOperations((int) $walletId, $path);
        } catch (\Exception $exception) {
            $output->writeln('Export failed.');
            $output->writeln($exception->getMessage());

            return Command::FAILURE;
        }
        $output->writeln('The file was exported to: ' . $path);
        $output->writeln('-------------------------------------');

        return Command::SUCCESS;
    }

}
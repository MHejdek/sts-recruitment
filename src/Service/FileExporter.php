<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use App\Repository\WalletRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Filesystem\Filesystem;

class FileExporter
{
    public function __construct(
        private WalletRepository $walletRepository,
        private Filesystem $filesystem,
    )
    {
    }

    public function exportOperations(string $walletId): void
    {
        if (!is_numeric($walletId)) throw new \Exception(sprintf('Please provide valid integer id. Provided: %d', $walletId));
        $walletId = (int) $walletId;

        $wallet = $this->walletRepository->find($walletId);

        if (!$wallet) throw new \Exception(sprintf('No wallet found for given id: %d', $walletId));

        /** @var Collection $operations */
        $operations = $wallet->getOperations();

        if ($operations->isEmpty())
            throw new \Exception(sprintf('There are not any operations for given wallet id: %d', $walletId));

        $operationsArray = $this->mapOperationsToArray($operations);
        $operationsCsvString = $this->mapOperationsArrayToCsvString($operationsArray);

        $this->filesystem->dumpFile('/var/www/file.csv', $operationsCsvString);
    }

    private function mapOperationsToArray(Collection $operations): array
    {
        $mappedOperations = $operations->map(function(Operation $operation) {
            return [
                $operation->getId(),
                $operation->getType(),
                $operation->getAmount(),
            ];
        });
        return $mappedOperations->toArray();
    }

    private function mapOperationsArrayToCsvString(array $operations): string
    {
        $csv = "id,type,amount\r\n";

        foreach ($operations as $operation) {
            $csv .=  '"' . implode('","', $operation) . '"' . "\r\n";
        }
        return $csv;
    }

}


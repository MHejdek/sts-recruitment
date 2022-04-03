<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use Symfony\Component\Filesystem\Filesystem;

class FileExporter
{
    public function __construct(
        private OperationRepository $operationRepository,
        private Filesystem $filesystem,
    )
    {
    }

    public function exportOperations(int $walletId, string $path): void
    {
        $operations = $this->operationRepository->findBy(['walletId' => $walletId]);

        // map each operation array
        $rows = array_map(function (Operation $operation) {
            return [
              $operation->getId(),
              $operation->getWalletId(),
              $operation->getType(),
            ];
        }, $operations);

        // map each operation array to string
        $csv = '';

        foreach ($rows as $offset => $row) {
            $endLine = $offset === (count($rows) - 1) ? "" : "\r\n";
            $csv .=  '"' . implode('","', $row) . '"' . $endLine;
        }

        $this->filesystem->dumpFile($path, $csv);
    }

}


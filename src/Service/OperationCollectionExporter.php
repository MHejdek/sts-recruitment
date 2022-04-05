<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Filesystem\Filesystem;

class OperationCollectionExporter implements EntityCollectionExporterInterface
{
    public function __construct(
        private Filesystem $filesystem,
        private OperationCollectionMapper $entityCollectionMapper
    )
    {
    }

    public function exportToCsv(Collection $collection): void
    {
        $operationsCsvString = $this->entityCollectionMapper->mapToCsv($collection);
        $this->filesystem->dumpFile('/var/www/file.csv', $operationsCsvString);
    }

}


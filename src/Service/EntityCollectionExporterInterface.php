<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\Common\Collections\Collection;

interface EntityCollectionExporterInterface
{
    public function exportToCsv(Collection $collection): void;

}
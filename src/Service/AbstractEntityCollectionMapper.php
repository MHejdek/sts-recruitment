<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\Common\Collections\Collection;

abstract class AbstractEntityCollectionMapper
{
    public function mapToCsv(Collection $collection): string
    {
        $mappedEntities = $this->mapCollectionToArray($collection);
        return $this->mapArrayToCsvString($mappedEntities);
    }

    abstract protected function mapCollectionToArray(Collection $collection): array;

    abstract protected function mapArrayToCsvString(array $entities): string;

}
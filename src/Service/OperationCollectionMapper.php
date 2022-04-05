<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use Doctrine\Common\Collections\Collection;

class OperationCollectionMapper extends AbstractEntityCollectionMapper
{
    protected function mapCollectionToArray(Collection $collection): array
    {
        $mappedOperations = $collection->map(function(Operation $operation) {
            return [
                $operation->getId(),
                $operation->getType(),
                $operation->getAmount(),
            ];
        });
        return $mappedOperations->toArray();
    }

    protected function mapArrayToCsvString(array $operations): string
    {
        $csv = "id,type,amount\r\n";

        foreach ($operations as $operation) {
            $csv .=  '"' . implode('","', $operation) . '"' . "\r\n";
        }
        return $csv;
    }

}
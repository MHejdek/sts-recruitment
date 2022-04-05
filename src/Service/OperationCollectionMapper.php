<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use Doctrine\Common\Collections\Collection;

class OperationCollectionMapper implements EntityCollectionMapperInterface
{
    public function mapToCsv(Collection $collection): string
    {
        $operationArray = $this->mapOperationCollectionToArray($collection);
        return $this->mapOperationArrayToCsvString($operationArray);
    }

    private function mapOperationCollectionToArray(Collection $operationCollection): array
    {
        $mappedOperations = $operationCollection->map(function(Operation $operation) {
            return [
                $operation->getId(),
                $operation->getType(),
                $operation->getAmount(),
            ];
        });
        return $mappedOperations->toArray();
    }

    private function mapOperationArrayToCsvString(array $operationArray): string
    {
        $csv = "id,type,amount\r\n";

        foreach ($operationArray as $operation) {
            $csv .=  '"' . implode('","', $operation) . '"' . "\r\n";
        }
        return $csv;
    }

}
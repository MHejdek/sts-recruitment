<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\Common\Collections\Collection;

interface EntityCollectionMapperInterface
{
    public function mapToCsv(Collection $collection): string;

}
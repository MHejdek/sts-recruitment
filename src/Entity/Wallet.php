<?php

declare(strict_types=1);

namespace App\Entity;

class Wallet
{
    private int $id;

    private float $amount;

    public function __construct(
        string $name,
        float $amount
    )
    {
        $this->amount = $amount;
    }

}
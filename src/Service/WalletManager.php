<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use App\Entity\Wallet;

class WalletManager
{
    public function updateWallet(Wallet $wallet, int $operationAmount, string $operationType): void
    {
        $this->addOperation($wallet, $operationAmount, $operationType);
        $this->setAmount($wallet, $operationAmount, $operationType);
    }

    private function addOperation(Wallet $wallet, int $operationAmount, string $operationType): void
    {
        $operation = new Operation($operationType, $operationAmount);
        $operation->setWallet($wallet);
    }

    private function setAmount(Wallet $wallet, int $operationAmount, string $operationType): void
    {
        if ($operationType === 'subtraction') $wallet->setAmount($wallet->getAmount() - $operationAmount);
        if ($operationType === 'addition') $wallet->setAmount($wallet->getAmount() + $operationAmount);
    }

}
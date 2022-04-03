<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use App\Entity\Wallet;

class WalletManager
{
    public function addAmountToWallet(Wallet $wallet, int $amount): void
    {
        $wallet->setAmount($wallet->getAmount() + $amount);
        $this->addOperationToWallet($wallet, 'addition', $amount);
    }

    public function substractAmountFromWallet(Wallet $wallet, int $amount): void
    {
        $wallet->setAmount($wallet->getAmount() - $amount);
        $this->addOperationToWallet($wallet, 'substraction', $amount);
    }

    private function addOperationToWallet(Wallet $wallet, string $type, int $amount): void
    {
        $operation = new Operation($type, $amount);
        $operation->setWallet($wallet);
    }

}
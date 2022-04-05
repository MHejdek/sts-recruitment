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
        $operation = new Operation('addition', $amount);
        $operation->setWallet($wallet);
    }

    public function subtractAmountFromWallet(Wallet $wallet, int $amount): void
    {
        $wallet->setAmount($wallet->getAmount() - $amount);
        $operation = new Operation('subtraction', $amount);
        $operation->setWallet($wallet);
    }

}
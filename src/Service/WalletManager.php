<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Operation;
use App\Entity\Wallet;

class WalletManager
{
    public function updateWallet(Wallet $wallet, string $type, int $amount): Wallet
    {
        if ($type === 'addition') $wallet->setAmount($wallet->getAmount() + $amount);
        if ($type === 'substraction') $wallet->setAmount($wallet->getAmount() - $amount);

        return $this->addOperationToWallet($wallet, $type);
    }

    private function addOperationToWallet(Wallet $wallet, string $type): Wallet
    {
        $operation = new Operation($wallet->getId(), $type);
        $wallet->addOperation($operation);

        return $wallet;
    }

}
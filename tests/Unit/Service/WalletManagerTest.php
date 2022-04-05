<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Operation;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletManagerTest extends TestCase
{
    public function testUpdateWalletAdditionOperationWithSuccess(): void
    {
        $wallet = new Wallet();

        // assert wallet amount is 0 at the start
        $this->assertEquals(0, $wallet->getAmount());

        $operation = new Operation('addition', 200);
        $operation->setWallet($wallet);
        $wallet->setAmount($wallet->getAmount() + 200);

        // assert wallet amount was updated properly to 200
        $this->assertEquals(200, $wallet->getAmount());
        // assert if proper operation type was set
        $this->assertEquals('addition', $wallet->getOperations()->first()->getType());
        // assert if proper operation amount was set
        $this->assertEquals(200, $wallet->getOperations()->first()->getAmount());
    }

    public function testUpdateWalletSubtractionOperationWithSuccess(): void
    {
        $wallet = new Wallet();

        // assert wallet amount is 0 at the start
        $this->assertEquals(0, $wallet->getAmount());

        $operation = new Operation('subtraction', -100);
        $operation->setWallet($wallet);
        $wallet->setAmount($wallet->getAmount() - 100);

        // assert wallet amount was updated properly to -100
        $this->assertEquals(-100, $wallet->getAmount());
        // assert if proper operation type was set
        $this->assertEquals('subtraction', $wallet->getOperations()->first()->getType());
        // assert if proper operation amount was set
        $this->assertEquals(-100, $wallet->getOperations()->first()->getAmount());
    }

}
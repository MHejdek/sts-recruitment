<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Operation;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletManagerTest extends TestCase
{

    public function testAddAmountToWalletWithSuccess(): void
    {
        $wallet = new Wallet();

        // assert wallet amount is 0 at the start
        $this->assertEquals(0, $wallet->getAmount());

        // set amount on wallet
        $wallet->setAmount($wallet->getAmount() + 200);
        $operation = new Operation('addition', 200);
        $operation->setWallet($wallet);

        // assert wallet amount was updated properly to 200
        $this->assertEquals(200, $wallet->getAmount());
        // assert if proper operation type was set
        $this->assertEquals('addition', $wallet->getOperations()->first()->getType());
        // assert if proper operation amount was set
        $this->assertEquals(200, $wallet->getOperations()->first()->getAmount());
    }

    public function testSubstractAmountFromWalletWithSuccess(): void
    {
        $wallet = new Wallet();

        // assert wallet amount is 0 at the start
        $this->assertEquals(0, $wallet->getAmount());

        // set amount on wallet
        $wallet->setAmount($wallet->getAmount() - 100);
        $operation = new Operation('substraction', -100);
        $operation->setWallet($wallet);

        // assert wallet amount was updated properly to -100
        $this->assertEquals(-100, $wallet->getAmount());
        // assert if proper operation type was set
        $this->assertEquals('substraction', $wallet->getOperations()->first()->getType());
        // assert if proper operation amount was set
        $this->assertEquals(-100, $wallet->getOperations()->first()->getAmount());
    }

}
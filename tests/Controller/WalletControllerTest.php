<?php

namespace App\Tests\Controller;

use App\Entity\Wallet;
use App\Service\WalletManager;
use PHPUnit\Framework\TestCase;

class WalletControllerTest extends TestCase
{
    private WalletManager $walletManager;

    protected function setUp(): void
    {
        $this->walletManager = new WalletManager();
    }

    public function testAddAmountSuccess(): void
    {
        $wallet = new Wallet();
        $this->walletManager->addAmountToWallet($wallet, 200);
        $this->assertEquals(200, $wallet->getAmount());
    }

    public function testSubstractAmountSuccess(): void
    {
        $wallet = new Wallet();
        $wallet->setAmount(200);
        $this->walletManager->substractAmountFromWallet($wallet,100);
        $this->assertEquals(100, $wallet->getAmount());
    }

}
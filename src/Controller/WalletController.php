<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Service\WalletManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/wallet',
    name: 'wallet_'
)]
class WalletController extends AbstractController
{
    public function __construct(
        private WalletRepository $walletRepository,
        private WalletManager $walletManager,
    )
    {
    }

    #[Route(
        path: '/create',
        name: 'create'
    )]
    public function createWallet(): Response
    {
        $wallet = new Wallet();
        // persist new wallet to the database
        $this->walletRepository->create($wallet);

        return new Response(
            sprintf(
                'Wallet with id: %d was created',
                $wallet->getId()
            )
        );
    }

    #[Route(
        path: '/add-amount/{id}/{amount}',
        name: 'add_amount',
        requirements: [
            'id' => '\d+',
            'amount' => '\d+',
        ]
    )]
    public function addAmount(Wallet $wallet, int $amount): Response
    {
        // run wallet updates: setAmount + addOperation
        $this->walletManager->updateWallet($wallet, $amount, 'addition');
        // persist updated wallet to the database
        $this->walletRepository->update($wallet);

        return new Response(
            sprintf(
                'The amount: %d was added to wallet with id: %d',
                $amount,
                $wallet->getId()
            )
        );
    }

    #[Route(
        path: '/subtract-amount/{id}/{amount}',
        name: 'subtract_amount',
        requirements: [
            'id' => '\d+',
            'amount' => '\d+',
        ]
    )]
    public function subtractAmount(Wallet $wallet, int $amount): Response
    {
        // run wallet updates: setAmount + addOperation
        $this->walletManager->updateWallet($wallet, $amount, 'subtraction');
        // persist updated wallet to the database
        $this->walletRepository->update($wallet);

        return new Response(
            sprintf(
                'The amount: %d was subtracted from wallet with id: %d',
                $amount,
                $wallet->getId()
            )
        );
    }

    #[Route(
        path: '/get-amount/{id}',
        name: 'get_amount',
        requirements: [
            'walletId' => '\d+',
        ]
    )]
    public function getAmount(Wallet $wallet): Response
    {
        return new Response(
            sprintf(
                'The amount in wallet with id: %d equals: %d',
                $wallet->getId(),
                $wallet->getAmount()
            )
        );
    }

}
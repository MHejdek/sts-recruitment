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
    path: '/wallet',
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
        $this->walletRepository->create($wallet);

        return new Response('Wallet with id: ' . $wallet->getId() . ' was created.');
    }

    #[Route(
        path: '/add-amount/{id}/{amount}',
        name: 'add_amount',
        requirements: ['amount' => '\d+', 'id' => '\d+'],
    )]
    public function addAmount(Wallet $wallet, int $amount): Response
    {
        $wallet = $this->walletManager->updateWallet($wallet, 'addition', $amount );
        $this->walletRepository->update($wallet);

        return new Response('The amount in wallet with id: ' . $wallet->getId() . ' was updated.');
    }

    #[Route(
        path: '/substract-amount/{id}/{amount}',
        name: 'substract_amount',
        requirements: ['amount' => '\d+', 'id' => '\d+'],
    )]
    public function substractAmount(Wallet $wallet, int $amount): Response
    {
        $wallet = $this->walletManager->updateWallet($wallet, 'substraction', $amount );
        $this->walletRepository->update($wallet);

        return new Response('The amount in wallet with id: ' . $wallet->getId() . ' was updated.');
    }

    #[Route(
        path: '/get-amount/{id}',
        name: 'get_amount',
        requirements: ['id' => '\d+'],
    )]
    public function getAmount(Wallet $wallet): Response
    {
        return new Response('The amount on account equals: ' . $wallet->getAmount());
    }

}
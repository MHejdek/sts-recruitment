<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/wallet', name: 'wallet_')]
class WalletController extends AbstractController
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    #[Route(path: '/create', name: 'create')]
    public function createWallet(): Response
    {
        $wallet = new Wallet(0);
        $this->walletRepository->create($wallet);
        return new Response();
    }

    #[Route(path: '/add-amount/{amount}', name: 'add_amount', requirements: ['amount' => '\d+'])]
    public function addAmount(int $amount): Response
    {
        return new Response();
    }

    #[Route(path: '/substract-amount/{amount}', name: 'substract_amount', requirements: ['amount' => '\d+'])]
    public function substractAmount(int $amount): Response
    {
        return new Response();
    }

    #[Route(path: '/get-amount', name: 'get_amount')]
    public function getAmount(): Response
    {
        return new Response();
    }

}
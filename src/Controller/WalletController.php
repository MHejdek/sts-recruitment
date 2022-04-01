<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Operation;
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

        return new Response('New wallet with id: ' . $wallet->getId() . ' was created.');
    }

    #[Route(path: '/add-amount/{id}/{amount}', name: 'add_amount', requirements: ['amount' => '\d+', 'id' => '\d+'])]
    public function addAmount(Wallet $wallet, int $amount): Response
    {
        $operation = new Operation($wallet->getId(),'addition');
        $wallet->addOperation($operation);
        $wallet->setAmount($wallet->getAmount() + $amount);
        $this->walletRepository->update($wallet);

        return new Response('The amount in wallet with id: ' . $wallet->getId() . ' was updated.');
    }

    #[Route(path: '/substract-amount/{id}/{amount}', name: 'substract_amount', requirements: ['amount' => '\d+', 'id' => '\d+'])]
    public function substractAmount(Wallet $wallet, int $amount): Response
    {
        $operation = new Operation($wallet->getId(), 'substraction');
        $wallet->addOperation($operation);
        $wallet->setAmount($wallet->getAmount() - $amount);
        $this->walletRepository->update($wallet);

        return new Response('The amount in wallet with id: ' . $wallet->getId() . ' was updated');
    }

    #[Route(path: '/get-amount/{id}', name: 'get_amount', requirements: ['id' => '\d+'])]
    public function getAmount(Wallet $wallet): Response
    {
        return new Response('The amount on account equals: ' . $wallet->getAmount());
    }

}
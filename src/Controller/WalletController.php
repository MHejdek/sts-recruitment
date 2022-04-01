<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/wallet', name: 'wallet_')]
class WalletController extends AbstractController
{
    #[Route(path: '/create', name: 'create')]
    public function createWallet(): Response
    {
        return new Response();
    }

    #[Route(path: '/add-amount/{amount}', name: 'add_amount', requirements: ['amount' => '\d+'])]
    public function addAmount(float $amount): Response
    {
        return new Response();
    }

    #[Route(path: '/substract-amount/{amount}', name: 'substract_amount', requirements: ['amount' => '\d+'])]
    public function substractAmount(float $amount): Response
    {
        return new Response();
    }

    #[Route(path: '/get-amount', name: 'get_amount')]
    public function getAmount(): Response
    {
        return new Response();
    }

}
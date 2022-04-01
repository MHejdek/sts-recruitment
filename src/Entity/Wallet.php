<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private int $id;

    #[Column(type: 'integer')]
    private int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

}
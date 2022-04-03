<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use JetBrains\PhpStorm\Pure;

#[Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private int $id;

    #[Column(type: 'integer')]
    private int $amount;

    #[OneToMany(
        mappedBy: 'wallet_id',
        targetEntity: Operation::class,
        cascade: ['persist'],
    )]
    private Collection $operations;

    #[Pure] public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->amount = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function addOperation(Operation $operation): void
    {
        $this->operations[] = $operation;
    }

}
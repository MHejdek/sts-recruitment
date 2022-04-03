<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Operation
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private int $id;

    #[Column(type: 'string')]
    private string $type;

    #[Column(type: 'integer')]
    private int $amount;

    #[ManyToOne(targetEntity: Wallet::class, inversedBy: 'operations')]
    #[JoinColumn(name: 'wallet', referencedColumnName: 'id', nullable: false)]
    private Wallet $wallet;

    public function __construct(string $type, int $amount)
    {
        $this->type = $type;
        $this->amount = $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setWallet(Wallet $wallet): void
    {
        $wallet->addOperation($this);
        $this->wallet = $wallet;
    }

}
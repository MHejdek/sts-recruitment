<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Operation
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private int $id;

    #[Column(type: 'integer')]
    private int $walletId;

    #[Column(type: 'string')]
    private string $type;

    public function __construct(int $walletId, string $type)
    {
        $this->walletId = $walletId;
        $this->type = $type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getType(): string
    {
        return $this->type;
    }

}
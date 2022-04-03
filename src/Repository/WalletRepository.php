<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

final class WalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function create(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();
    }

    public function update(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();
    }

    public function getOperations(int $walletId): Collection
    {
        $wallet = $this->find($walletId);
        return $wallet->getOperations();
    }

}
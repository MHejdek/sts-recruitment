<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

final class WalletRepository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Wallet::class);
        $this->logger = $logger;
    }

    public function create(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();

        $this->logger->notice("New wallet was added to the database with id: " . $wallet->getId());
    }

    public function update(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();

        $this->logger->notice("The wallet with id: " . $wallet->getId() . ' was updated');
    }

}